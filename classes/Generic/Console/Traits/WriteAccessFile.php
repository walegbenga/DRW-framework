<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 30/04/20
* Time : 10:43
*/
namespace Generic\Console\Traits;

trait WriteAccessFile
{
    public function writePhpExt($extension)
    {
        $os_info = $this->getOS();
        if ($os_info === "Windows NT") {
            return "extension=php_$extension.dll" . PHP_EOL;
        } else {
            return "extension=$extension.so" . PHP_EOL;
        }
    }

    public function filepath()
    {
        if (is_dir('../../php/ext')) {
            if (chdir('../../php/ext')) {
                return getcwd();
            } //("../../../php/ext");
            //$filepath = '../../../php/ext';

            elseif (is_dir('../../../php/ext')) {
                if (chdir('../../.`./php/ext')) {
                    return getcwd();
                } //("../../php/ext");
                #$filepath = '../../php/ext';

                elseif (chdir("../../ext")) {
                    return getcwd();
                }
            }
        } elseif(is_dir("../ext")){
            if(chdir("../ext")){
                return getcwd();
            }
        }else{
            try{
                shell_exec("cd");
                if(is_dir("php/ext")){
                    if(chdir("php/ext")){
                        return getcwd();
                    }
                }else{
                    $filepath = php_ini_loaded_file();
                    $filepath = str_ireplace("\php.ini", "\ext", $filepath);
                    if(is_dir($filepath)){
                        if(chdir($filepath)){
                            return getcwd();
                        }
                    }
                }
            }catch(Exception $e){
                echo $e->getMessage() . PHP_EOL;
                echo "You have no php install on your system\n";
            }
        }
        //("../../ext");
        #$filepath = "../../ext";
    }

    private function safefilerewrite($fileName, $dataToSave)
    {
        echo "my\n";
        if ($fp = fopen($fileName, 'w')) {
            echo "do\n";
            $startTime = microtime(true);
            do {
                echo "g\n";
                $canWrite = flock($fp, LOCK_EX);

                // If lock not obtained sleep for 0 - 100 milliseconds, to avoid collision and CPU load
                if (!$canWrite) {
                    usleep(round(rand(0, 100)*1000));
                }
            } while ((!$canWrite)and((microtime(true)-$startTime) < 5));

            //file was locked so now we can store information
            if ($canWrite) {
                echo "lot\n";
                fwrite($fp, $dataToSave);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }

    // https://stackoverflow.com/questions/5695145/how-to-read-and-write-to-an-ini-file-with-php
    public function writePhpIni($array, $file)
    {
        echo "all..\n";
        $res = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $res[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
            } else {
                $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
            }
        }
        $this->safefilerewrite($file, implode("\r\n", $res));
    }

    public function accessPHPIni($extension)
    {
        # https://www.php.net/manual/en/function.parse-ini-file.php
        // Get the path to php.ini using the php_ini_loaded_file()
        // function available as of PHP 5.2.4

        echo "There\n";
        echo "$extension\n";
        $ini_path = php_ini_loaded_file();
        var_dump($ini_path);
        // Parse php.ini
        $ini = parse_ini_file($ini_path);
        print_r($ini);
        $ini = "extension=$ini[$extension]";
        echo "\n\n";
        print_r($ini);
        $c = $this->writePhpIni($this->writePhpExt($extension), $ini);
        echo "\n\n\n";
        print_r($c);
    }

    #if(!function_exists('write_ini_file')){
    /**
    * Write an ini configuration file
    *
    * @param string $file
    * @param array  $array
    * @return bool
    */
    public function write_ini_file($file, $array = [])
    {
        // check first argument is string
        if (!is_string($file)) {
            throw new \InvalidArgumentException('Function argument 1 must be a string.');
        }

        // check second argument is array
        if (!is_array($array)) {
            throw new \InvalidArgumentException('Function argument 2 must be an array.');
        }

        // process array
        $data = array();
        foreach ($array as $key => $val) {
            if (is_array($val)) {
                $data[] = "[$key]";
                foreach ($val as $skey => $sval) {
                    if (is_array($sval)) {
                        foreach ($sval as $_skey => $_sval) {
                            if (is_numeric($_skey)) {
                                $data[] = $skey.'[] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            } else {
                                $data[] = $skey.'['.$_skey.'] = '.(is_numeric($_sval) ? $_sval : (ctype_upper($_sval) ? $_sval : '"'.$_sval.'"'));
                            }
                        }
                    } else {
                        $data[] = $skey.' = '.(is_numeric($sval) ? $sval : (ctype_upper($sval) ? $sval : '"'.$sval.'"'));
                    }
                }
            } else {
                $data[] = $key.' = '.(is_numeric($val) ? $val : (ctype_upper($val) ? $val : '"'.$val.'"'));
            }
            // empty line
            $data[] = null;
        }

        // open file pointer, init flock options
        $fp = fopen($file, 'w');
        $retries = 0;
        $max_retries = 100;

        if (!$fp) {
            return false;
        }

        // loop until get lock, or reach max retries
        do {
            if ($retries > 0) {
                usleep(rand(1, 5000));
            }
            $retries += 1;
        } while (!flock($fp, LOCK_EX) && $retries <= $max_retries);

        // couldn't get the lock
        if ($retries == $max_retries) {
            return false;
        }

        // got lock, write data
        fwrite($fp, implode(PHP_EOL, $data).PHP_EOL);

        // release lock
        flock($fp, LOCK_UN);
        fclose($fp);

        return true;
    }
    #}
}
