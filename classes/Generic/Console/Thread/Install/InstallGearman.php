<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 28/04/20
* Time : 15:07
*/

namespace Generic\Console\Thread\Install;

use Generic\Console\Traits\WriteAccessFile;
use Generic\Console\Traits\SystemConfig;

class InstallGearman
{
    use WriteAccessFile, SystemConfig;

    private function installUnix()
    {
        echo "Installing php gearmand...\n";
        /*shell_exec("pecl install gearman");*/

        echo "Downloading and installing of Gearman and libgearman...\n";
        shell_exec("tar xzf gearmand-1.1.0.tar.gz");
        shell_exec("cd gearmand-1.1.0");
        echo "Running MAKE test before installing to make sure everything checks out ok...\n";
        shell_exec("./configure && make && make test");
        echo "Installing gearman...\n";
        shell_exec("make install");
        echo "Gearman version is ";
        shell_exec("gearmand -v");
    }
    
    public function install()
    {
        $os_info = $this->getOS();
        $os_name = $this->getOSInformation();
    
        echo "$os_info...\n";
        switch ($os_info) {
            // https://stackoverflow.com/questions/14982921/how-to-install-gearman-with-php-extension/30592132#30592132
            case $os_info == "Linux":
            case $os_info == "freeBSD":
            case $os_info == "OpenBSD":
            case $os_info == "mac OS":

            if ($os_name['name'] == "Ubuntu" || $os_name['name'] == "Debian") {
                echo "Installing header boost-devel...\n";
                shell_exec("apt-get install libboost-all-dev");
                echo "Installing gperf...\n";
                shell_exec("apt-get install gperf");
                echo "Installing libevent...\n";
                shell_exec("apt-get install libevent-dev");
                echo "Installing uuid...\n";
                shell_exec("apt-get install uuid-dev");
                echo "Installing libcloog-ppl0...\n";
                shell_exec("apt-get install libcloog-ppl-dev");
                $this->installUnix();
                shell_exec("sudo bash -c \"echo extension=gearmand.so > /etc/php5.X-sp/conf.d/gearmand.ini\"");
            } elseif ($os_name['name'] == "RedHat" || $os_name['name'] == "CentOS") {
                echo "Installing header boost-devel...\n";
                shell_exec("yum install boost-devel");
                echo "Installing gperf...\n";
                shell_exec("yum install gperf");
                echo "Installing libevent...\n";
                shell_exec("yum install libevent-devel");
                echo "Installing uuid...\n";
                shell_exec("yum install uuid-devel");
                $this->installUnix();
            } elseif ($os_name['name'] == "Fedora") {
                echo "Installing header boost-devel...\n";
                shell_exec("dnf install boost-devel");
                echo "Installing gperf...\n";
                shell_exec("dnf install gperf");
                echo "Installing libevent...\n";
                shell_exec("dnf install libevent-devel");
                echo "Installing uuid...\n";
                shell_exec("dnf install uuid-devel");
                $this->installUnix();
            }

            /*echo "Installing php gearmand...\n";
            shell_exec("pecl install gearman");*/
            
            if ($os_info == "freeBSD") {
                # https://www.freshports.org/devel/pear-Net_Gearman/
                shell_exec("cd /usr/ports/devel/pear-Net_Gearman/ && make install clean");
                shell_exec("pkg install php72-pear-Net_Gearman");
                $this->installUnix();
            } elseif ($os_info == "openBSD") {
                echo "Downloading pecl-gearman and installing pecl-gearman...\n";
                shell_exec("pkg_add php-gearman");
                $this->installUnix();
            } elseif ($os_info == "mac OS") {
                echo "Installing gearman php on mac...\n";
                shell_exec("brew install php56-gearman");
                $this->installUnix();
            }

            // Update PHP ini file
            echo "Writing to php ini file...\n";
            $ini_path = php_ini_loaded_file();
        echo "Accessing and writing to php directory...\n";
        file_put_contents($ini_path, $this->writePhpExt("gearman"), FILE_APPEND | LOCK_EX);
            break;
            /*
            case $os_info == "mac OS":
            echo "Installing gearman php on mac...\n";
            shell_exec("brew install php56-gearman");
            echo "Installing gearman php on mac";
            shell_exec("brew install gearman");

            break;

            case $os_info == "freeBSD":
            # https://www.freshports.org/devel/pear-Net_Gearman/
            shell_exec("cd /usr/ports/devel/pear-Net_Gearman/ && make install clean");
            shell_exec("pkg install php72-pear-Net_Gearman");

            # https://www.freshports.org/devel/gearmand-devel/
            shell_exec("cd /usr/ports/devel/gearmand-devel/ && make install clean");
            shell_exec("pkg install gearmand-devel");
            break;

            case $os_info == "OpenBSD":
            echo "Downloading pecl-gearman and installing pecl-gearman...\n";
            shell_exec("pkg_add php-gearman");

            echo "Downloading and installing gearman and libgearman...\n";
            shell_exec("pkg_add php-gearman")
            break;
            */
            case $os_info == "Windows NT":
            echo "You are using $os_info...\n";
            echo "Windows version coming soon but you can use it on Linux Ubuntu, Debian, Fedora, RedHat, mac OS, freeBSD and OpenBSD.\n";
            break;

            default:
            echo "Your operating system is not supported at the moment. You also can contribute to this open project...\n";
            break;
        }
    }
}
