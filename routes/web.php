<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return "view('welcome')";
});

Route::get('/home', function () {
    return "home page web work";
});

Route::get('/log-routes', function () {
    $routes = Artisan::call('route:list');
    $routes = Artisan::output();
    return $routes;
});
