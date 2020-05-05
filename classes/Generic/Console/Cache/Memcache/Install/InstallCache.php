<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 08/04/20
* Time : 08:13
*/

namespace Generic\Cache\Install;

class InstallCache{
  
  private function getOSInformation()
  {
    if(false == function_exists("shell_exec") || false == is_readable("/etc/os-release")){
      return null;
    }

    $os         = shell_exec('cat /etc/os-release');
    $listIds    = preg_match_all('/.*=/', $os, $matchListIds);
    $listIds    = $matchListIds[0];

    $listVal    = preg_match_all('/=.*/', $os, $matchListVal);
    $listVal    = $matchListVal[0];

    array_walk($listIds, function(&$v, $k){
        $v = strtolower(str_replace('=', '', $v));
      });

    array_walk($listVal, function(&$v, $k){
        $v = preg_replace('/=|"/', '', $v);
      });

    return array_combine($listIds, $listVal);
  }

  private function checkPHPVersion()
  {
    return PHP_VERSION_ID;
  }

  private function is64Bits(){
    return strlen(decbin(~0)) == 64;
  }

  private function  downloadFile($url, $filepath)
  {
    $fp = fopen($filepath, 'w+');
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    return (filesize($filepath) > 0)? true : false;
  }

  public function installMemchached()
  {
    $os_info = $this->getOSInformation();

    switch($os_info){
      case $os_info['name'] === 'Windows': // Windows os
      if(version_compare(phpversion(), "5.2.9", ">"))// Checking PHP version
      {
        //PHP_INT_SIZE == 8 ?
        //$bit = $this->is64Bits();// Check the system bit
        // Retrieving the specific PHP version
        $php_version  = str_replace('0', '.', PHP_VERSION_ID);
        $php_version = substr_replace($php_version, "", -1);

        $bit = $this->is64Bits() == 64 ? "x64" : "x86";

        $thread_type = ZEND_THREAD_SAFE ? 'ts' : 'nts'; // Thread Safe checking code

        // Getting the VC version runtime in windows
        $result = shell_exec("php -v");
        $r = strstr($result, 'MSV');
        $k = explode("(", $r);
        $vc = strtolower(str_ireplace("ms", "", $k[0]));

        // Filepath to download
        $filepath = "";
        if(scandir("../php/ext"))
        $filepath = "../php/ext";
        else
        $filepath = "../ext";

        downloadFile("https://windows.php.net/downloads/pecl/releases/memcache/3.0.8/logs/php_memcache-3.0.8-$php_version-$thread_type-$vc-$bit-logs.zip", ""/*$filepath*/);

        // Getting the downloaded file name
        $file = "php_memcache-3.0.8-$php_version-$thread_type-$vc-$bit.zip";

        $path = pathinfo(realpath($filepath), PATHINFO_DIRNAME);

        $zip = new ZipArchive;
        $res = $zip->open($file);
        if($res === TRUE){
          // extract it to the path we determined above
          $zip->extractTo($path);
          $zip->close();
          echo "WOOT! $file extracted to $path";
        } else{
          echo "Doh! I couldn't open $file";
        }

        // Download Memcache
        $memcache_dir = mkdir("../../memcache");

        $download_type = "memcached-win$bit-1.4.5-14.zip";
        downloadFile("http://s3.amazonaws.com/downloads.northscale.com/$download_type", "../../memcache"/*$filepath*/);

        // Getting the downloaded file name
        #$file2 = "memcached-win64-1.4.4-14.zip";

        $path = pathinfo(realpath($memcache_dir), PATHINFO_DIRNAME);

        $zip = new ZipArchive;
        $res = $zip->open($download_type);
        if($res === TRUE){
          // extract it to the path we determined above
          $zip->extractTo($path);
          $zip->close();
          echo "WOOT! $download_type extracted to $path";

          // php.ini to allow usage of memcache
          $data = "extension=php_memcache.dll" . PHP_EOL . PHP_EOL;
          $data .= "[Memcache]" . PHP_EOL;
          $data .= "memcache.allow_failover = 1" . PHP_EOL;
          $data .= "memcache.max_failover_attempts=20" . PHP_EOL;
          $data .= "memcache.chunk_size =8192";
          $data .= "memcache.default_port = 11211";

          if(opendir("../php")){
            // Open php.ini file
            if(file_exists("php.ini") && is_writable("php.ini")){
              $file = file("php.ini");
              if(str_replace(";extension=php_memcache.dll", "extension=php_memcache.dll", $file)){
                echo "Memcached enabled in php.ini file..."
              }
              else{
                echo "Memcached extension not found in php.ini.\nBut don't worry, we are writing that for you...\n";
                file_put_contents("php.ini", $data, FILE_APPEND | LOCK_EX);
                echo "Memcached enabled in php.ini file...";
              }
            }
          }

          // Install script here
          // https://stackoverflow.com/questions/34637281/how-to-open-a-batch-file-from-php-script-with-administrator-privileges
          // For memcached 1.4.4 downward
          // Credit https://phpcodez.com/install-memcached-xampp-windows-10/
          shell_exec('C:\\WINDOWS\\system32\\cmd.exe /c 2>&1 "C:\\memcache\\memcached\\memcached.exe"');
          shell_exec("C:\\memcache\\memcached\\memcached.exe -d install");
          shell_exec("C:\\memcache\\memcached\\memcached.exe -d start");
          echo "Memcached successfully installed and started.\n You can start working now";

          // for 1.4.5 upward
          shell_exec('C:\\WINDOWS\\system32\\cmd.exe /c 2>&1 schtasks /create /sc onstart /tn memcached /tr "\'c:\memcached\memcached.exe\' -m 512"');
        } else
        {
          echo "Doh! I couldn't open $file";
        }
            
      }
      else
      {
        echo "Your PHP version is less than 5.3.0";
        return;
      }
      break;
        
      case $os_info['name'] === 'Linux':
      // https://serverpilot.io/docs/how-to-install-the-php-memcache-extension/
      echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
      echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
      echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";

      if(version_compare(phpversion(), "7.0.0", ">=")){
        echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
        echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
        echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
        shell_exec("sudo apt-get -y install gcc make autoconf libc-dev pkg-config");
        shell_exec("sudo apt-get -y install zlib1g-dev");
        shell_exec("sudo apt-get -y install libmemcached-dev");
        shell_exec("sudo pecl7.X-sp install memcached");

        // Configure
        shell_exec("sudo bash -c \"echo extension=memcached.so > /etc/php7.X-sp/conf.d/memcached.ini\"");
        shell_exec("sudo service php7.X-fpm-sp restart");
        echo "Succesfully installed memcached and the server is started for you already. Happy coding";
        return;
      }
      elseif(version_compare(phpversion(), "5.2.9", ">") && version_compare(phpversion(), "7.0.0", "<"))
      {
        shell_exec("sudo apt-get -y install gcc make autoconf libc-dev pkg-config");
        shell_exec("sudo apt-get -y install zlib1g-dev");
        shell_exec("sudo apt-get -y install libmemcached-dev");
        shell_exec("sudo pecl5.X-sp install memcached-2.2.0");

        // Configure
        shell_exec("sudo bash -c \"echo extension=memcached.so > /etc/php5.X-sp/conf.d/memcached.ini\"");
        shell_exec("sudo service php5.X-fpm-sp restart");
      }
      break;

      case $os_info['name'] === 'Mac':
      if(version_compare(phpversion(), "5.2.9", ">") && version_compare(phpversion(), "7.0.0", "<"))
      {
        // Retrieving the specific PHP version
        $php_version  = str_replace('0', '', PHP_VERSION_ID);
        $php_version = substr_replace($php_version, "", -1);

        // Running the command
        shell_exec("brew search memcached");
        shell_exec("brew install memcached");
        shell_exec("php$php_version-memcached");

        # start memcached daemon with 24MB on port 11211 (default)
        shell_exec("memcached -d -m 24 -p 11211");

        // Add to php.ini file
        $php_dir = '';
        $data = "extension=memcached.so";
        if(opendir('../php')){
          // Open php.ini file
          if(file_exists("php.ini") && is_writable("php.ini")){
            // Get the file content
            $file = file("php.ini");
            if(str_replace(";extension=memcached.so", "extension=memcached.so", $file))
            // Restart php or php5-fpm and your server. Verify
            shell_exec("php -i | grep memcached");
            else
            file_put_contents("php.ini", $data, FILE_APPEND | LOCK_EX);
          }
        }
      }
      break;

      default:
      echo "We will soon write one for your operating system only if your operating system is not yet supported.\nThank you.";
      break;
    }
  }

  // Install vanish
  public function installVarnish()
  {
    $os_info = getOSInformation();

    switch ($os_info) {
      case $of_info["name"] == "Windows":
        if (scandir("cygwin64") || scandir("cygwin32") || scandir("cygwin86")) 
        {
          echo "You have vanish installed on your system already.";
        }
        else
        {
          echo "Downloading Varnish for windows...";
          is64Bits() == 64 ? $this->downloadFile("http://cygwin.com/setup-x86_64.exe", "") : $this->downloadFile("http://cygwin.com/setup-x86.exe", "");
          echo "Finish downloading cygwin.....\nInstalling will begins shortly";
          $download_name = '';
          is64Bits() == 64 ? $download_name = "setup-x86_64.exe" : $download_name = "setup-x86.exe";
          shell_exec("C:\\$download_name");
        }
        break;
      case $oo_info["name"] == "Linux":
          echo "grabbing the repository...\n";
          echo "Adding the repository to the source list and save.\n";
        if ($os_info["name"] == "Ubuntu" || $os_info["name"] == "Debian") 
        {
          "curl -L https://packagecloud.io/varnishcache/varnish41/gpgkey | sudo apt-key add -";
          "sudo nano /etc/apt/sources.list.d/varnishcache_varnish41.list" ;

          "deb https://packagecloud.io/varnishcache/varnish41/ubuntu/ trusty main";
          "deb-src https://packagecloud.io/varnishcache/varnish41/ubuntu/ trusty main";

          if($os_info["name"] == "Ubuntu")
          {
            echo "Updating and installing varnish...";
            shell_exec("sudo apt-get update");
            shell_exec("sudo apt-get install varnish");
            echo "About to configure Varnish.....\n";

            // Change location
            shell_exec("cd");
            shell_exec("/etc/default/");
            if(file_get_contents("varnish"))
              str_replace(" -b 95.85.10.242:8081", "-b 95.85.10.242:8080", "varnish")

            echo "Copying the default file named varnish.service.....";
            shell_exec("cd");
            shell_exec("cp /lib/systemd/system/varnish.service /etc/systemd/system/");
            shell_exec("cd");
            //shell_exec("/etc/systemd/system/varnish.service");
            file_get_contents("/etc/systemd/system/varnish.service");
            str_replace("80", "8080", "/etc/systemd/system/varnish.service");
            echo "Modifying default.vcl file...";
            echo "Backing up default.vcl...";
            shell_exec("cp /etc/varnish/default.vcl /etc/varnish/default.vcl.bak");
            file_get_contents("/etc/varnish/default.vcl");
            str_replace("backend default {.host = \"127.0.0.1\";.port = \"80\";}", "backend default {.host = \"127.0.0.1\";.port = \"8080\";}", "/etc/varnish/default.vcl");

            // Configuring Apache to work with Varnish
            echo "About to configure apache to work with varnish...";
            // Change the apache listen port
            file_get_contents("/etc/apache2/ports.conf");
            /*
            Locate the listen directive
            Change the value of the listen port to 8080 (you can use any available listen port)
            Save your changes to ports.conf and exit the text editor
            */

            // edit /etc/apache2/sites-available/000-default.conf
            file_get_contents("/etc/apache2/sites-available/000-default.conf");
            str_replace("<VirtualHost 127.0.0.1:80>", "<VirtualHost 127.0.0.1:8080>", "<VirtualHost 127.0.0.1:8080>");

            // Restarting varnish and apache
            shell_exec("service varnish restart");
            shell_exec("service apache restart");
          }
        }
        elseif($os_info["name"] == "FreeBSD")
        {
          if(shell_exec("pkg_add -r varnish"))
            shell_exec("cd /usr/ports/varnish && make install clean");
        }
        elseif($os_info["name"] == "Redhat" || elseif($os_info["name"] == "CentOS"))
        {
          
        }

        break;

        case $of_info["name"] == "Macos":
          shell_exec("brew install varnish");

          break;
      default:
        echo "Sorry, your operating system is not supported at the moment";
        break;
    }
  }

  public function installRedis()
  {
    $os = checkPHPVersion();
    echo "About to Install Redis....\n";
    echo "But first we have to detect your operating system....\n";
    echo "You are using $os...\n";
    echo "installing Redis on $os...\n";

    switch ($os) 
    {
      case $os === "mac":
        shell_exec("brew install redis");
        echo "Finish installing redis...\n";
        echo "Starting redis...\n";
        shell_exec("brew services start redis");
        break;
      
      case $os === "Windows":
        downloadFile("https://github.com/dmajkic/redis/downloads", "");
        echo "Finish installing redis...\n";
        echo "Starting redis...\n";
        shell_exec("brew services start redis");
        break;

        case $os === "Linux" || $os === "mac":
        // Source from https://auth0.com/blog/introduction-to-redis-install-cli-commands-and-data-types/
          shell_exec("cd");
          shell_exec("mkdir redis && cd redis");
          shell_exec("curl -O http://download.redis.io/redis-stable.tar.gz");
          shell_exec("tar xvzf redis-stable.tar.gz");
          shell_exec("cd redis-stable");
          shell_exec("make");
          shell_exec("make test");
          shell_exec("sudo cp src/redis-server /usr/local/bin/");
          shell_exec("sudo cp src/redis-cli /usr/local/bin/");
          shell_exec(" sudo make install");
          shell_exec("redis-server");

          /*if($os_info["name"] == "Ubuntu" || $os_info["name"] == "Debian")
          {
            shell_exec("sudo apt-get update");
            shell_exec("sudo apt-get install redis-server");
          }
          elseif($os_info["name"] == "CentOs" || $os_info["name"] == "Debian")
        downloadFile("https://github.com/dmajkic/redis/downloads", "");
        echo "Finish installing redis...\n";
        echo "Starting redis...\n";
        shell_exec("brew services start redis");*/
        break;
      default:
        echo "Sorry, your opearating system is not supported at the moment.\n";
        break;
    }

    // Download the php redis package
    shell_exec("pecl install redis");
  }
}

//https://github.com/dmajkic/redis/downloads