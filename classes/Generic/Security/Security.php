<?php
declare(strict_types=1);

/**
* Created by : Gbenga Ogunbule
* Location : Ijebu Ode
* Date : 30/05/20
* Time : 11:11
*/

class Security
{
    public static function security_check()
    {
        if (isset($_SESSION) && (!isset($_POST['csrftoken']) || $_POST['csrftoken'] != $_SESSION['csrftoken'])) {
            return false;
        }
        // HTTP_REFERER easily spoofed, but make the check anyway
        if (isset($_SERVER['HTTP_REFERER']) && parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) != $_SERVER['HTTP_HOST']) {
            return false;
        }
        return true;
    }
}
