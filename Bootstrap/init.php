<?php

use App\Core\Request;

define('BASEPATH',__DIR__ . '/../');



include BASEPATH . "/vendor/autoload.php";


$dotenv = Dotenv\Dotenv::createImmutable(BASEPATH);
$dotenv->load();


$request = new Request();

include BASEPATH . "Helpers/helper.php";
include BASEPATH . "Routes/web.php";