<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 28/04/20
* Time : 15:07
*/

namespace Generic\Console\Debugger\Install;

use Generic\Console\Traits\WriteAccessFile;
use Generic\Console\Traits\SystemConfig;
use Generic\CustomException\CustomException;

class InstallDebugger
{
    use WriteAccessFile, SystemConfig;

    public function installXDebug()
    {
        $os_info = $this->getOS();
        $os_name = $this->getOSInformation();
        $php_version = $this->getPhpVersion();

        switch ($os_info) {
            case $os_info == "Linux":
                echo "Xdebug installation to begin shortly...\n";

                try{
                    shell_exec("pecl install xdebug");
                }catch(CustomException $e){
                    echo "Error, probably due to network error\n";
                }

                // Write to php.ini
              $ini_path = php_ini_loaded_file();
              #var_dump($this->ini_path);
              $file = PHP_EOL . "zend_extension=\"/usr/local/php/modules/xdebug.so\"";
              echo "Accessing and writing to php directory...\n";
              file_put_contents($ini_path, $file, FILE_APPEND | LOCK_EX);
                break;
            
            case $os_info == "Windows NT":
                
                if (version_compare(phpversion(), "5.2.9", ">")) {
                    if ($php_version >= "5.3") {
                        $bit = $this->is64Bits() == 64 ? "x64" : "x86";

                        $thread_type = $this->threadType(); // Thread Safe checking code

                        // Getting the VC version runtime in windows
                        $vc = $this->VcVersion();
                        // Check vc number
                        $vc_num = $this->vcNum();

                        $xdebug_type = "";
                        
                        switch ($php_version) {
                            case $php_version == "5.3":
                                if ($vc == "vc9") {
                                    if ($thread_type == "nts") {
                                        $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.2.7-5.3-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.2.7-5.3-$vc-$thread_type-x86_64.dll";
                                    } else {
                                        $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.2.7-5.3-$vc.dll" : "http://xdebug.org/files/php_xdebug2.2.7-5.3-$vc-x86_64.dll";
                                    }
                                }

                                break;

                                case $php_version == "5.4":
                                case $php_version == "5.5":
                                case $php_version == "5.6":
                                case $php_version == "7.0":
                                //http://xdebug.org/files/php_xdebug-2.4.1-5.4-vc9.dll
                                    if ($vc == "vc9") {
                                        if ($thread_type == "nts") {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-5.4-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.4.1-5.4-$vc-x86_64.dll";
                                        } else {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-5.4-$vc.dll" : "http://xdebug.org/files/php_xdebug2.4.1-5.4-$vc-x86_64.dll";
                                        }
                                    } elseif ($vc == "vc11") {
                                        $php = "";
                                        if ($php_version == "5.5") {
                                            $php = $php_version;
                                        } elseif ($php_version == "5.6") {
                                            $php = $php_version;
                                        }

                                        if ($thread_type == "nts") {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-$php-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.4.1-$php-$vc-x86_64.dll";
                                        } else {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-$php-$vc.dll" : "http://xdebug.org/files/php_xdebug2.4.1-$php-$vc-x86_64.dll";
                                        }
                                    } elseif ($vc == "vc14") {
                                        if ($thread_type == "nts") {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-7.0-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.4.1-7.0-$vc-x86_64.dll";
                                        } else {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.4.1-7.0-$vc.dll" : "http://xdebug.org/files/php_xdebug2.4.1-7.0-$vc-x86_64.dll";
                                        }
                                    }

                                    break;

                                case $php_version == "7.1":
                                case $php_version == "7.2":
                                case $php_version == "7.3":
                                case $php_version == "7.4":

                                    if ($vc == "vc14") {
                                        if ($thread_type == "nts") {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.9.5-7.1-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.9.5-7.1-$vc-x86_64.dll";
                                        } else {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.9.5-7.1-$vc.dll" : "http://xdebug.org/files/php_xdebug2.9.5-7.1-$vc-x86_64.dll";
                                        }
                                    } elseif ($vc == "vc15") {
                                        if ($thread_type == "nts") {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.9.5-$php_version-$vc-$thread_type.dll" : "http://xdebug.org/files/php_xdebug2.9.5-$php_version-$vc-x86_64.dll";
                                        } else {
                                            $bit == "x86" ? $xdebug_type = "http://xdebug.org/files/php_xdebug2.9.5-$php_version-$vc.dll" : "http://xdebug.org/files/php_xdebug2.9.5-$php_version-$vc-x86_64.dll";
                                        }
                                    }
                                    try{
                                        shell_exec("powershell -command \"& { Start-BitsTransfer -Source $xdebug_type -Destination Xdebug.zip }\"");
                                    }catch(CustomException $e){
                                        echo "Error, probably due to network error\n";
                                    }
                                    // Move the file to the php ext directory

                                    $filepath = $this->filepath();
                                    $xdebug_name = explode("/", $xdebug_type);
                                    #echo "$xdebug_name[4]/$filepath";
                                    try{
                                        shell_exec("move $xdebug_name[4] $filepath");
                                    }catch(CustomException $e){
                                        echo "Error, probably due to network error\n";
                                    }
                                    break;
                            default:
                                echo "Sorry, your platform is not supported by xdebug. Probably, your vc version might be greater than or lesser than you PHP version" . PHP_EOL;
                                break;
                        }
                    }
                }
            break;

            case $os_info == "freeBSD":
            case $os_info == "OpenBSD":
                echo "Downloading and compiling of the source...\n";

                if ($php_version >= "7.1") {
                    try{
                        shell_exec("wget [php_xdebug-2.9.5-$php_version-vc9.dll]");
                        shell_exec("cd xdebug-2.9.5");
                        shell_exec("./configure --enable-xdebug");
                        shell_exec("make");
                        shell_exec("make install");

                        // Use instead og wget
                        #shell_exec("curl -O https://github.com/downloads/dmajkic/redis/redis-2.4.5-win32-win64.zip");

                        echo "Writing to php ini file...\n";
                        $ini_path = php_ini_loaded_file();
                        echo "Accessing and writing to php directory...\n";
                        file_put_contents($ini_path, "zend_extension=\"/cd xdebug-2.9.5/xdebug.so\"", FILE_APPEND | LOCK_EX);
                    }catch(CustomException $e){
                        echo "Error, probably due to network error\n";
                    }
                } elseif ($php_version >= "5.4" || $php_version <= "5.6") {
                    try{
                        shell_exec("wget [php_xdebug-2.4.1-$php_version-vc9.dll]");
                    }catch(CustomException $e){
                        echo "Error, probably due to network error\n";
                    }
                } elseif ($php_version == "5.3") {
                    try{
                        shell_exec("wget [php_xdebug-2.2.7-5.3-vc9.dll]");
                    }catch(CustomException $e){
                        echo "Error, probably due to network error\n";
                    }
                } else {
                    echo "Sorry, we can't help you to install xdebug on your system. You can do it manually.\n";
                }
                
            break;
            default:
                echo "Your system is currently not supported by us.\n";
                break;
        }
    }
}
