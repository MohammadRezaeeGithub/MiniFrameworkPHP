<?php

use App\Core\Routing\Route;
use App\Middleware\BlockFirefox;

Route::get('/','HomeController@index',[BlockFirefox::class]);

Route::get('/post/{slug}','HomeController@index',[BlockFirefox::class]);

Route::add(['get','post'],'/a',function(){
    echo 'welcome';
});

Route::get('/b',function(){
    echo 'ok saved';
});

Route::put('/c',['Controller','Method']);

Route::get('/d','Controller@method');
 