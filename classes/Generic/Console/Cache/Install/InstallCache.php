<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 08/04/20
* Time : 08:13
*/

namespace Generic\Console\Cache\Install;

use Symfony\Component\Console\Helper\ProgressBar;
use Generic\Console\Traits\WriteAccessFile;
use Generic\Console\Traits\SystemConfig;

class InstallCache
{
    use WriteAccessFile, SystemConfig;
    private $vc; // This property is used to get the windows vc version
    private $os_info;
  
    //https://stackoverflow.com/questions/3938534/download-file-to-server-from-url
    private function downloadFile($url, $filepath)
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

    // https://stackoverflow.com/questions/4366730/how-do-i-check-if-a-string-contains-a-specific-word
    private function containsWord($str, $word)
    {
        return !!preg_match('#\\b' . preg_quote($word, '#') . '\\b#i', $str);
    }
  
    public function installMemchached()
    {
        $os_info = $this->getOS();
        $os_name = $this->getOSInformation();

        switch ($os_info) {
      case $os_info === "Windows NT": // Windows os

      if (version_compare(phpversion(), "5.2.9", ">")) {// Checking PHP version
          $php_version = $this->getPhpVersion();

          $bit = $this->is64Bits() == 64 ? "x64" : "x86";

          $thread_type = $this->threadType(); // Thread Safe checking code
          
          // Getting the VC version runtime in windows
          $vc = $this->VcVersion();
          // Check vc number
          $vc_num = $this->vcNum();

          $memcache_type = $vc_num <= 11 ? "3.0.8" : "4.0.5";

          $filepath = $this->filepath(); //"";
          echo "$filepath exist\n";
          echo "About to download...\n";

          // php memcache download site
          // https://stackoverflow.com/questions/46830703/downloading-large-files-in-windows-command-prompt-powershell
          "pecl install gearman";
          shell_exec("powershell -command \"& { Start-BitsTransfer -Source https://windows.php.net/downloads/pecl/releases/memcache/$memcache_type/php_memcache-$memcache_type-$php_version-$thread_type-$vc-$bit.zip -Destination php_memcache.zip }\"");

          echo "file downloaded\n";
        
          // Getting the downloaded file name
          $file = "php_memcache.zip";

          // Unzipping the downloaded file
          echo "Unzipping the file...\n";
         
          $zip = new \ZipArchive;
          $res = $zip->open($file);
        
          if ($res === true) {
              // extract it to the path we determined above
              $zip->extractTo($filepath);
              $zip->close();
              echo "WOOT! $file extracted to $filepath\n";
          } else {
              echo "Doh! I couldn't open $file\n";
          }

          // Memcache download
          echo "About to download memcache...\Checking if memcache folder exist\n";
          $memcache_dir = "../../../../../memcache";
          if (!is_dir($memcache_dir)) {
              echo "About to create Memcache folder...\n";
              mkdir("../../../../../memcache");
              echo "Memcache created successfully in " . realpath($memcache_dir) . "...\n";
          } else {
              echo "Memcache folder already exist in " . pathinfo(realpath($memcache_dir), PATHINFO_DIRNAME). ".\n";
          }

          #$download_type = "memcached-win64-1.4.4-14.zip";
          $download_type = $this->is64Bits() == 64 ? "http://downloads.northscale.com/memcached-1.4.5-amd64.zip" : "http://downloads.northscale.com/memcached-1.4.5-x86.zip";

          echo "Memcache application download about to start\n";
          shell_exec("powershell -command \"& { Start-BitsTransfer -Source $download_type -Destination memcache.zip }\"");

          echo "Finish downloading...\n";
          $file2 = "memcache.zip";
          $path = pathinfo(realpath($memcache_dir), PATHINFO_DIRNAME);

          echo "Unzipping the memcached version1.4.5 \n";
          $zip = new \ZipArchive;
          $res = $zip->open($file2);
          if ($res === true) {
              // extract it to the path we determined above
              $zip->extractTo($path);
              $zip->close();
              echo "WOOT! memcached extracted to $path\n";

              // php.ini to allow usage of memcache
              $data = "extension=php_memcache.dll" . PHP_EOL . PHP_EOL;
              $data .= "[Memcache]" . PHP_EOL;
              $data .= "memcache.allow_failover = 1" . PHP_EOL;
              $data .= "memcache.max_failover_attempts=20" . PHP_EOL;
              $data .= "memcache.chunk_size =8192";
              $data .= "memcache.default_port = 11211";
              
              // Write to php.ini
              $ini_path = php_ini_loaded_file();
              var_dump($ini_path);
              // Parse php.ini
              #$ini = parse_ini_file($ini_path, true);
              #print_r($ini);
              #$ini['memcache'][';extension'] = 'php_memcached.dll';
              #$this->write_ini_file($ini_path, $ini);
              echo "Accessing and writing to php directory...\n";
              file_put_contents($ini_path, $this->writePhpExt("memcache"), FILE_APPEND | LOCK_EX);

              // Starting memcached
              $memcache_folder_end = $this->is64Bits() == 64 ? "amd64" : "x86";
              echo "Starting memcached server...\n";

              // https://www.itread01.com/p/464505.html
              shell_exec('C:\\WINDOWS\\system32\\cmd.exe /c 2>&1 schtasks /create /sc onstart /tn memcached /tr "\'c:\memcached-$memcache_folder_end\memcached.exe\' -m 512"');
          #C:\memcached-amd64\memcached.exe c:\memcached\memcached.exe
          }// end if $res
          else {
              echo "Doh! I couldn't open file";
          }
      }// end of if php version
      else {
          echo "Your PHP version is less than 5.3.0";
          return;
      }
      break;
        
      case $os_info === 'Linux':
      if ($os_name['name'] === 'Ubuntu' || $os_name["name"] === 'Debian') {
          // https://serverpilot.io/docs/how-to-install-the-php-memcache-extension/
          echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
          echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";
          echo "When you are shown the prompt \" libmemcached directory [no] :\"\ntype or paste the following text exactly as shown and press Enter.\nno --disable-memcached-sasl";

          if (version_compare(phpversion(), "7.0.0", ">=")) {
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
          } elseif (version_compare(phpversion(), "5.2.9", ">") && version_compare(phpversion(), "7.0.0", "<")) {
              shell_exec("sudo apt-get -y install gcc make autoconf libc-dev pkg-config");
              shell_exec("sudo apt-get -y install zlib1g-dev");
              shell_exec("sudo apt-get -y install libmemcached-dev");
              shell_exec("sudo pecl5.X-sp install memcached-2.2.0");

              // Configure
              shell_exec("sudo bash -c \"echo extension=memcached.so > /etc/php5.X-sp/conf.d/memcached.ini\"");
              shell_exec("sudo service php5.X-fpm-sp restart");
          }

          // https://github.com/memcached/memcached/wiki/Install
          echo "installing libevent...\n";
          shell_exec("apt-get install libevent-dev");

          echo "installing from source...\n";
          shell_exec("wget https://memcached.org/latest");
          shell_exec("tar -zxf memcached-1.5.0.tar.gz");
          shell_exec("cd memcached-1.5.0");
          shell_exec("./configure --prefix=/usr/local/memcached");
          shell_exec("make && make test && sudo make install");

      #$this->accessPHPIni("memcached");
      } elseif ($os_name["name"] === "CentOS" || $os_name["name"] === "Redhatlinux") {
          # https://www.unixmen.com/install-memcached-en-php-memcache/
          # https://www.lullabot.com/articles/installing-memcached-on-redhat-or-centos
          echo "installing php pear and php pecl...\n";
          shell_exec("yum install php-pear");
          shell_exec("yum Install php-pecl-memcached");

          echo "Installing php memcached...\n";
          shell_exec("pecl install memcached");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("memcached"), FILE_APPEND | LOCK_EX);

          echo "installation of memcached started...\n";
          shell_exec('yum update -y');
          shell_exec("yum install memcached");

          echo "Configuring memcached...\n";
          #shell_exec("vi /etc/sysconfig/memcached");

          $data = "PORT=11211";
          $data .= "USER=memcached";
          $data .= "MAXCONN=1024";
          $data .= "CACHESIZE=2048";
          $data .= "OPTIONS=\"\"";

          if (is_dir("/etc/sysconfig")) {
              if (chdir("/etc/sysconfig")) {
                  if (file_exists("memcached")) {
                      echo "writing to the file...\n";
                      file_put_contents("memcached", $data, FILE_APPEND | LOCK_EX);
                  }
              }
          }
          echo "Start memcached...\n";
          shell_exec("chkconfig --levels 235 memcached on");
          shell_exec("/etc/init.d/memcached start");
      } elseif ($os_name["name"] === "Fedora") {
          # https://www.if-not-true-then-false.com/2010/install-memcached-on-centos-fedora-red-hat/
          echo "installing php pecl..\n";
          shell_exec("dnf install php php-pecl-memcached");
          echo "Finish Installing php memcached...\n";

          echo "installing memcached...\n";
          shell_exec("dnf install memcached");

          $this->accessPHPIni("memcached");

          $memcached = "PORT=11211" . PHP_EOL;
          $memcached .= "USER=memcached" . PHP_EOL;
          $memcached .= "MAXCONN=1024" . PHP_EOL;
          $memcached .= "CACHESIZE=2048" . PHP_EOL;
          $memcached .= "OPTIONS=\"\"" . PHP_EOL;

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("memcached"), FILE_APPEND | LOCK_EX);

          if (is_dir("/etc/sysconfig")) {
              if (chdir("/etc/sysconfig")) {
                  if (file_exists("memcached")) {
                      echo "writing to the file...\n";
                      file_put_contents("memcached", $data, FILE_APPEND | LOCK_EX);
                  }
              }
          }
      }
      break;

      case $os_info === 'mac OS':
      if (version_compare(phpversion(), "5.2.9", ">")) {

        // Running the command
          shell_exec("brew search memcached");
          shell_exec("brew install memcached");
          shell_exec("php $php_version-memcached");

          # start memcached daemon with 24MB on port 11211 (default)
          shell_exec("memcached -d -m 24 -p 11211");

          // Add to php.ini file
          $php_dir = '';
          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("memcached"), FILE_APPEND | LOCK_EX);
      } else {
          echo "Your php version is not supported, pleasde upgrade to php 5.3 upward. Thank you.\n";
      }
      break;

      case $os_info === 'freeBSD':
      // https://daemon-notes.com/articles/web/php/caching
      // or
      // https://icesquare.com/wordpress/installing-apache-php-mysql-and-memcached-on-freebsd/
      if (version_compare(phpversion(), "5.2.9", ">")) {
          // Retrieving the specific PHP version
          $php_version  = $this->getPhpVersion();

          // Running the command
          echo "Downloading pecl-memcached...\n";
          shell_exec("cd /usr/ports/databases/pecl-memcached");
        
          echo "installing pecl-memcached...\n";
          shell_exec("make install clean");
        
          //shell_exec("/etc/rc.conf");
          echo "Enabling pecl-memcached in rc.conf...\n";
        
          if (is_dir("/etc/rc.conf") && chdir("/etc/rc.conf")) {
              // add this to enable
              if (file_exists("rc.conf")) {
                  file_put_contents("rc.conf", "memcached_enable=\"YES\"", FILE_APPEND | LOCK_EX);
              }
          }

          echo "installing memcached database...\n";
          shell_exec("cd /usr/ports/databases/memcached");
        
          echo "installing memcached database...\n";
          shell_exec("make install clean");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("memcached"), FILE_APPEND | LOCK_EX);

          # start memcached daemon with 24MB on port 11211 (default)
          echo "starting memcached...\n";
          shell_exec("/usr/local/bin/memcached -d -u nobody");
      }
      break;

      case $os_info === "OpenBSD":
      if (version_compare(phpversion(), "5.2.9", ">")) {
          // Retrieving the specific PHP version
          $php_version  = $this->getPhpVersion();

          // Running the command
          // https://www.openbsd.org/faq/faq15.html#PkgInstall
          echo "Downloading pecl-memcached and installing pecl-memcached...\n";
          shell_exec("pkg_add php-memcached");
        
        
          //shell_exec("/etc/rc.conf");
          echo "Enabling pecl-memcached in rc...\n";
        
          if (is_dir("/etc/rc") && chdir("/etc/rc")) {
              // add this to enable
              if (file_exists("rc")) {
                  file_put_contents("rc", "memcached_enable=\"YES\"", FILE_APPEND | LOCK_EX);
              }
          }

          echo "installing memcached database...\n";
          shell_exec("pkg_add memcached");

          # start memcached daemon with 24MB on port 11211 (default)
          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("memcached"), FILE_APPEND | LOCK_EX);

          echo "starting memcached...\n";
          shell_exec("/usr/local/bin/memcached -d -u nobody");
      }
      break;
      default:
      echo "We will soon write one for your operating system, if your operating system is not yet supported.\nThank you.";
      break;
    }
    }

    // Install vanish
    public function installVarnish()
    {
        $os_name = $this->getOSInformation();
        $os_info = $this->getOS();
        // https://stackoverflow.com/questions/4645082/get-absolute-path-of-initially-run-script
        #echo getcwd();
        #echo $_SERVER['PHP_SELF'];
        switch ($os_info) {
      case $os_info == "Windows NT":

      $php_version = $this->getPhpVersion();

      $bit = $this->is64Bits() == 64 ? "x64" : "x86";

      $thread_type = $this->threadType(); // Thread Safe checking code

      // Getting the VC version runtime in windows
      $vc = $this->VcVersion();
      // Check vc number
      $vc_num = $this->vcNum();

      $varnish_type = $vc_num <= 9 ? "1.2.2" : "1.2.3";

      $filepath = $this->filepath(); //"";
        
      echo "About to download...\n";

      // php varnish download site
      shell_exec("powershell -command \"& { Start-BitsTransfer -Source https://windows.php.net/downloads/pecl/releases/varnish/$varnish_type/php_varnish-$varnish_type-$php_version-$thread_type-$vc-$bit.zip -Destination php_varnish.zip }\"");

      echo "file downloaded\n";
        
      // Getting the downloaded file name
      // Unzipping the downloaded file
      echo "Unzipping the file...\n";
         
      $zip = new \ZipArchive;
      $res = $zip->open("php_varnish.zip");
        
      if ($res === true) {
          // extract it to the path we determined above
          $zip->extractTo($filepath);
          $zip->close();
          echo "WOOT! file extracted to $filepath\n";
      } else {
          echo "Doh! I couldn't open file\n";
      }

      $ini_path = php_ini_loaded_file();
      echo "Accessing and writing to php directory...\n";
      file_put_contents($ini_path, $this->writePhpExt("varnish"), FILE_APPEND | LOCK_EX);

      if (is_dir("../../../cygwin64") || is_dir("../../../cygwin32") || is_dir("../../../cygwin86") || is_dir("../../cygwin64") || is_dir("../../cygwin32") || is_dir("../../../cygwin86")) {
          echo "You have vanish installed on your system already.";
      } else {
          echo "Downloading Varnish for windows...";
          $this->is64Bits() == 64 ? shell_exec("powershell -command \"& { Start-BitsTransfer -Source http://cygwin.com/setup-x86_64.exe }\"") : ("powershell -command \"& { Start-BitsTransfer -Source http://cygwin.com/setup-x86.exe }\"");

          echo "Finish downloading cygwin.....\nInstallation will begins shortly...\n";
          $download_name = '';
          $this->is64Bits() == 64 ? $download_name = "setup-x86_64.exe" : $download_name = "setup-x86.exe";

          echo "Writing to the php ini configuration file...\n";
          shell_exec("start $download_name");
          echo "Finish installation\n";
      }
      break;
      
      case $os_info == "Linux":
      echo "Your operating system is $os_info .\n";
      echo "grabbing the repository...\n";
      echo "Adding the repository to the source list and save.\n";
      if ($os_info["name"] == "Ubuntu" || $os_info["name"] == "Debian") {
          shell_exec("curl -L https://packagecloud.io/varnishcache/varnish41/gpgkey | sudo apt-key add -");
          shell_exec("sudo nano /etc/apt/sources.list.d/varnishcache_varnish41.list");

          shell_exec("deb https://packagecloud.io/varnishcache/varnish41/ubuntu/ trusty main");
          shell_exec("deb-src https://packagecloud.io/varnishcache/varnish41/ubuntu/ trusty main");

          if ($os_name["name"] == "Ubuntu") {
              echo "Updating and installing varnish...";
              shell_exec("sudo apt-get update");
              shell_exec("sudo apt-get install varnish");
              echo "About to configure Varnish.....\n";

              // Change location
              shell_exec("cd");
              shell_exec("/etc/default/");
              if (file_get_contents("varnish")) {
                  str_replace(" -b 95.85.10.242:8081", "-b 95.85.10.242:8080", "varnish");
              }

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
      } elseif ($os_info["name"] == "Redhat" || $os_info["name"] == "CentOS") {
          echo "Installing php varnish...\n";
          #shell_exec("pecl install memcached");

          #echo "";

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("varnish"), FILE_APPEND | LOCK_EX);

          echo "installation of varnish started...\n";
          shell_exec('yum update -y');
          shell_exec("yum install varnish");

          echo "Configuring varnish...\n";
          #shell_exec("vi /etc/sysconfig/varnish");

          $data = "PORT=11211";
          $data .= "USER=varnish";
          $data .= "MAXCONN=1024";
          $data .= "CACHESIZE=2048";
          $data .= "OPTIONS=\"\"";

          if (is_dir("/etc/sysconfig")) {
              if (chdir("/etc/sysconfig")) {
                  if (file_exists("varnish")) {
                      echo "writing to the file...\n";
                      file_put_contents("varnish", $data, FILE_APPEND | LOCK_EX);
                  }
              }
          }
          echo "Start varnish...\n";
      #shell_exec("chkconfig --levels 235 memcached on");
        #shell_exec("/etc/init.d/memcached start");
      } elseif ($os_name["name"] === "Fedora") {
          # code...
          echo "installing php pecl..\n";
          shell_exec("dnf install php php-pecl-varnish");
          echo "Finish Installing php varnish...\n";

          echo "installing varnish...\n";
          shell_exec("dnf install varnish");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("varnish"), FILE_APPEND | LOCK_EX);

          if (is_dir("/etc/sysconfig")) {
              if (chdir("/etc/sysconfig")) {
                  if (file_exists("varnish")) {
                      echo "writing to the file...\n";
                      file_put_contents("varnish", $data, FILE_APPEND | LOCK_EX);
                  }
              }
          }
      }

      break;

      case $os_info == "Mac OS":
      shell_exec("php $php_version-memcached");
      shell_exec("brew install varnish");

      $ini_path = php_ini_loaded_file();
      echo "Accessing and writing to php directory...\n";
      file_put_contents($ini_path, $this->writePhpExt("varnish"), FILE_APPEND | LOCK_EX);

      break;

      case $os_info == "FreeBSD":
      if (shell_exec("pkg_add -r varnish")) {
          shell_exec("cd /usr/ports/varnish && make install clean");
      }
      break;
    
      case $os_info === "OpenBSD":
      if (version_compare(phpversion(), "5.2.9", ">")) {
          // Retrieving the specific PHP version
          $php_version  = $this->getPhpVersion();

          // Running the command
          // https://www.openbsd.org/faq/faq15.html#PkgInstall
          echo "Downloading pecl-varnish and installing pecl-varnish...\n";
          shell_exec("pkg_add php-varnish");
        
        
          //shell_exec("/etc/rc.conf");
          echo "Enabling pecl-varnish in rc...\n";
        
          if (is_dir("/etc/rc") && chdir("/etc/rc")) {
              // add this to enable
              if (file_exists("rc")) {
                  file_put_contents("rc", "varnish_enable=\"YES\"", FILE_APPEND | LOCK_EX);
              }
          }

          echo "installing varnish...\n";
          shell_exec("pkg_add varnish");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("varnish"), FILE_APPEND | LOCK_EX);

          # start varnish daemon with 24MB on port 11211 (default)
          echo "starting varnish...\n";
          shell_exec("/usr/local/bin/varnish -d -u nobody");
      }
      break;

      default:
      echo "Sorry, your operating system is not supported at the moment" . PHP_EOL;
      break;
    }
    }

    public function installRedis()
    {
        $php_version = $this->checkPHPVersion();
        $os_info = $this->getOS();

        echo "About to Install Redis....\n";
        echo "But first we have to detect your operating system....\n";
        echo "You are using $os_info...\n";
        echo "installing Redis on $os_info...\n";

        switch ($os_info) {
      /*case $os_info === "Mac OS":
      shell_exec("php$php_version-redis");
      shell_exec("brew install redis");
      echo "Finish installing redis...\n";

      $data = $this->writePhpExt();
      if(opendir('../php') && chdir("../php")){
      // Open php.ini file
      if(file_exists("php.ini") && is_writable("php.ini")){
      // Get the file content
      $file = file("php.ini");
      if(str_replace(";extension=redis.so", "extension=redis.so", $file))
      // Restart php or php5-fpm and your server. Verify
      shell_exec("php -i | grep redis");
      else
      file_put_contents("php.ini", $this->write("redis"), FILE_APPEND | LOCK_EX);
      }
      }
      echo "Starting redis...\n";
      shell_exec("brew services start redis");
      break;
      */
      case $os_info === "Windows NT":
    
      $php_version = phpversion();
      $php_version = $this->getPhpVersion();
      $bit = $this->is64Bits() == 64 ? "x64" : "x86";

      $thread_type = $this->threadType(); // Thread Safe checking code

      // Getting the VC version runtime in windows
      $vc = $this->VcVersion();

      // Check vc number
      $vc_num = $this->VcNum();

      $type = $vc_num <= 11 ? "2.2.7" : "4.2.0";
      echo $type . "\n";

      $filepath = $this->filepath();
      echo "Testing 1...\n";
      //wget https://github.com/libevent/libevent/releases/download/release-2.0.22-stable/libevent-2.0.22-stable.tar.gz;
  
      shell_exec("powershell -command \"& { Start-BitsTransfer -Source https://windows.php.net/downloads/pecl/releases/redis/$type/php_redis-$type-$php_version-$thread_type-$vc-$bit.zip -Destination php_redis.zip }\"");

      $path = $filepath;

      $zip = new \ZipArchive;
      $res = $zip->open("php_redis.zip");
        
      if ($res === true) {
          // extract it to the path we determined above
          $zip->extractTo($path);
          $zip->close();
          echo "WOOT! file extracted to $path\n";
      } else {
          echo "Doh! I couldn't open $file\n";
      }

      echo "Redis download start now\n";
      
      shell_exec("curl -O https://github.com/downloads/dmajkic/redis/redis-2.4.5-win32-win64.zip");
      #shell_exec("powershell -command \"& { (New-Object Net.WebClient).DownloadFile('https://github.com/downloads/dmajkic/redis/redis-2.4.5-win32-win64.zip', 'redis.zip') }\"");
      echo "Finish downloading redis...\n";
      echo "Redis installation start now but first we need to unzip redis...\n";
      echo "Unzipping redis...\n";

      $redis_dir = "../../../redis";
      if (is_dir($redis_dir)) {
          echo "It seems redis is already set up in this machine because a folder naqme redis already exist.\n";
      } else {
          mkdir($redis_dir);
      }

      $path = realpath($redis_dir);
      $zip = new \ZipArchive;
      $res = $zip->open("redis.zip");
      if ($res === true) {
          // extract it to the path we determined above
          $zip->extractTo($path);
          $zip->close();
          echo "WOOT! redis extracted to $path\n";

          // Starting redis
          $redis_type = $this->is64Bits() == 64 ? "64" : "86";

          if (is_dir($redis_dir)) {
              if (chdir($redis_dir)) {
                  echo "Am in redis directory...\n";
                  if (is_dir("32bit") && $redis_type == "86") {
                      if (chdir("32bit")) {
                          echo "Am in 32 bit folder...\n";
                          shell_exec("start redis-server.exe");
                      }
                  } elseif (is_dir("64bit") && $redis_type == "64") {
                      if (chdir("64bit")) {
                          echo "Am in 64 bit folder...\n";
                          shell_exec("start redis-server.exe");
                      }
                  }
                  $ini_path = php_ini_loaded_file();
                  echo "Accessing and writing to php directory...\n";
                  file_put_contents($ini_path, $this->writePhpExt("redis"), FILE_APPEND | LOCK_EX);
              }
          }
      }// end if $res
      break;

      case $os_info === "Linux":

      echo "About to Install php-redis...\n";
      if ($os_name["name"] == "Debian" || $os_name["name"] == "Ubuntu") {
          if (version_compare(phpversion(), "7.0.0", ">=")) {
              shell_exec("sudo pecl7.X-sp install php-redis");

              echo "Configuring php_redis...\n";
              shell_exec("sudo bash -c \"echo extension=redis.so > /etc/php7.X-sp/conf.d/redis.ini\"");
              shell_exec("sudo service php7.X-fpm-sp restart");
          } elseif (version_compare(phpversion(), "5.3.0", ">=")) {
              shell_exec("sudo pecl5.X-sp install php-redis");

              echo "Configuring redis to work with php...\n";
              shell_exec("sudo bash -c \"echo extension=redis.so > /etc/php5.X-sp/conf.d/redis.ini\"");
              shell_exec("sudo service php5.X-fpm-sp restart");
          }
      } elseif ($os_name["name"] == "Redhat" || $os_name["name"] == "CentOS") {
          # code...
          shell_exec("yum Install php-pecl-php-redis");
      } elseif ($os_name["name"] == "Fedora") {
          # code...
          shell_exec("dnf install php php-pecl-php-redis");
      }
      // https://www.redislabs.com/ebook/appendix-a/a-1-installation-on-debian-or-ubuntu-linux/
      shell_exec("cd");
      echo "Downloading the required software...\n";
      shell_exec("sudo apt-get update");
      shell_exec("sudo apt-get install make gcc python-dev");
      echo "Downloading redis...\n";
      shell_exec("wget -q http://redis.googlecode.com/files/redis-2.6.9.tar.gz");
      echo "Extracting the source code...\n";
      shell_exec("tar -xzf redis-2.6.9.tar.gz");

      shell_exec("cd redis-2.6.9");
      echo "About to compile redis...\n";
      shell_exec("/redis-2.6.9:$ make");
      echo "Compiling the redis source...\n";
      shell_exec("cd src && make all");
      echo "About to install redis...\n";
      shell_exec("/redis-2.6.9:$ sudo make install");
      echo "installation ongoing...\n";
      shell_exec("cd src && make install");


      $ini_path = php_ini_loaded_file();
      echo "Accessing and writing to php directory...\n";
      file_put_contents($ini_path, $this->writePhpExt("redis"), FILE_APPEND | LOCK_EX);

      echo "Start redis server...\n";
      shell_exec("/redis-2.6.9:$ redis-server redis.conf");

      // Source from https://auth0.com/blog/introduction-to-redis-install-cli-commands-and-data-types/
      /*shell_exec("mkdir redis && cd redis");
      shell_exec("curl -O http://download.redis.io/redis-stable.tar.gz");
      shell_exec("tar xvzf redis-stable.tar.gz");
      shell_exec("cd redis-stable");
      shell_exec("make");
      shell_exec("make test");
      shell_exec("sudo cp src/redis-server /usr/local/bin/");
      shell_exec("sudo cp src/redis-cli /usr/local/bin/");
      shell_exec(" sudo make install");
      shell_exec("redis-server");*/

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

      case $os_info === "mac OS":
      if (version_compare(phpversion(), "5.3.0", ">=")) {
          shell_exec("php $php_version-redis");
          // https://www.redislabs.com/ebook/appendix-a/a-2-installing-on-os-x/
          echo "Downloading the bootsrap script needed for installing rudix...\n";
          shell_exec("curl -O http://rudix.googlecode.com/hg/Ports/rudix/rudix.py");
          echo "installing rudix...\n";
          shell_exec("sudo python rudix.py install rudix");
          echo "Using rudix to install redis...\n";
          shell_exec("sudo rudix install redis");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("redis"), FILE_APPEND | LOCK_EX);

          echo "Starting server...\n";
          shell_exec("redis-server");
      }
      break;

      case $os_info === "freeBSD":
      if (shell_exec("pkg_add -r redis")) {
          shell_exec("cd /usr/ports/redis && make install clean");
      }
      break;

      case $os_info === "OpenBSD":
      if (version_compare(phpversion(), "5.2.9", ">")) {
          // Retrieving the specific PHP version
          $php_version  = $this->getPhpVersion();

          // Running the command
          // https://www.openbsd.org/faq/faq15.html#PkgInstall
          echo "Downloading pecl-redis and installing pecl-redis...\n";
          shell_exec("pkg_add php-redis");
        
        
          //shell_exec("/etc/rc.conf");
          echo "Enabling pecl-redis in rc...\n";
        
          if (is_dir("/etc/rc") && chdir("/etc/rc")) {
              // add this to enable
              if (file_exists("rc")) {
                  file_put_contents("rc", "redis_enable=\"YES\"", FILE_APPEND | LOCK_EX);
              }
          }

          echo "installing redis database...\n";
          shell_exec("pkg_add redis");

          $ini_path = php_ini_loaded_file();
          echo "Accessing and writing to php directory...\n";
          file_put_contents($ini_path, $this->writePhpExt("redis"), FILE_APPEND | LOCK_EX);

          # start redis daemon with 24MB on port 11211 (default)
          echo "starting redis...\n";
          shell_exec("/usr/local/bin/redis -d -u nobody");
      }
      break;
      default:
      echo "Sorry, your opearating system is not supported at the moment.\n";
      break;
    }

        // Download the php redis package
    //shell_exec("pecl install redis");
    }
}

//https://github.com/dmajkic/redis/downloads
