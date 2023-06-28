<?php

function siteUrl($route)
{
    return $_ENV['HOST'] . $route;
}

function assetUrl($route)
{
    return siteUrl("Assets/" . $route);
}

function view($path,$data = [])
{
    extract($data);

    $path = str_replace('.','/',$path);

    $fullPath = BASEPATH . "view/$path.php";
    
    include_once $fullPath;
}

function strContent($str,$needle,$case_sensetive = 0)
{
    if($case_sensetive){
        $pos = strpos($str,$needle);
    }else{
        $pos = stripos($str,$needle);
    }

    return ($pos != false) ? true : false;
}

function niceDump($var)
{
    echo "<pre style='text-align:left;display:block;background-color:#f1f1f1;border:1px solid #f1f3;padding:20px 0;'>";
    var_dump($var);
    echo "</pre>";
}

function niceDD($var)
{
    niceDump($var);
    die();
}