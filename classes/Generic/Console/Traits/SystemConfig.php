<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 30/04/20
* Time : 11:22
*/

namespace Generic\Console\Traits;

trait SystemConfig
{
    #private $cur_dir = getcwd();

    public function getOSInformation()
    {
        if (false == function_exists("shell_exec") || false == is_readable("/etc/os-release")) {
            return null;
        }

        $os         = shell_exec('cat /etc/os-release');
        $listIds    = preg_match_all('/.*=/', $os, $matchListIds);
        $listIds    = $matchListIds[0];

        $listVal    = preg_match_all('/=.*/', $os, $matchListVal);
        $listVal    = $matchListVal[0];

        array_walk($listIds, function (&$v, $k) {
            $v = strtolower(str_replace('=', '', $v));
        });

        array_walk(
            $listVal,
            function (&$v, $k) {
                $v = preg_replace('/=|"/', '', $v);
            }
        );

        return array_combine($listIds, $listVal);
    }

    public function checkPHPVersion()
    {
        return PHP_VERSION_ID;
    }

    // https://stackoverflow.com/questions/1482260/how-to-get-the-os-on-which-php-is-running
    public function getOS()
    {
        return  php_uname('s');
    }

    public function is64Bits()
    {
        return strlen(decbin(~0)) == 64;
    }

    public function getPhpVersion()
    {
        $php_version = phpversion();
        $php_version = substr($php_version, 0, -2);

        return $php_version;
    }

    public function threadType()
    {
        /*$thread_type =*/return ZEND_THREAD_SAFE ? 'ts' : 'nts';
    }

    public function VcVersion()
    {
        $result = shell_exec("php -v");
        $r = strstr($result, 'MSV');
        $k = explode("(", $r);
        $this->vc = strtolower(str_ireplace("ms", "", $k[0]));
        $this->vc = substr($this->vc, 0, -1);
        return $this->vc;
    }

    public function vcNum()
    {
        // Check vc number
        $vc_num = ltrim($this->vc, 'vc');
        return $vc_num;
    }
}
