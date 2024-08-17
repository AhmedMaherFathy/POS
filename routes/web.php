<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    $path = public_path('media/default/store.png');

    if (file_exists($path)) {
        return response()->file($path);
    }

    abort(404);
});

Route::get('/home', function () {
    return "home page web work";
});

Route::get('/log-routes', function () {
    $routes = Artisan::call('route:list');
    $routes = Artisan::output();
    return $routes;
});

Route::get('/run-command', function () {
    Artisan::call('migrate:fresh');
    return 'Command executed';
});
