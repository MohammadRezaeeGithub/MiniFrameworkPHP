<?php

namespace App\Utilitis;

class Utilitis
{
    public static function get($route)
    {
        return $_ENV['HOST'] .'Assets/'. $route;
    }

    public static function css($route)
    {
        return $_ENV['HOST'] .'Assets/Css/'. $route;
    }

    public static function js($route)
    {
        return $_ENV['HOST'] .'Assets/Js/'. $route;
    }
    
    public static function image($route)
    {
        return $_ENV['HOST'] .'Assets/Img'. $route;
    }
}