<?php

use App\Http\Middleware\AcceptApplicationJSON;
use App\Http\Middleware\LocaleMiddleware;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        
        $middleware->append([
            AcceptApplicationJSON::class,
            LocaleMiddleware::class,
        ]);

        $middleware->use([
            // StartSession::class,
            // ShareErrorsFromSession::class,
            // EnsureEmailIsVerified::class,
        ]);
        
        $middleware->alias([
            // 'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            //
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
