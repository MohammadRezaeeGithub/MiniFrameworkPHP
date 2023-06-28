<?php

namespace App\Utilitis;

class Url
{
    public static function current()
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $actual_link;
    }

    public static function currentRoute()
    {
        return strtok($_SERVER['REQUEST_URI'],'?');
    }
}