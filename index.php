<?php

use App\Core\Routing\Route;
use App\Core\Routing\Router;
use App\Models\User;
use App\Utilitis\Url;

include "Bootstrap/init.php";

// $user_data = [
//     'name' => 'Mohammad',
//     'email' => 'Mohammad@gmail.com',
//     'password' => '12345',
// ];
$newUser = new User();
// $newUser->create($user_data);
// $user = $newUser->find(2);
niceDD($newUser->delete(['id' => 10]));


// $router = new Router();
// $router->run();