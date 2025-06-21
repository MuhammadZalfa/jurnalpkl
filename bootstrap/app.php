<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'siswa' => \App\Http\Middleware\SiswaMiddleware::class,
            'instructor' => \App\Http\Middleware\InstructorMiddleware::class,
            'activity' => \App\Http\Middleware\LogLastUserActivity::class,
        ]);
        
        $middleware->web(append: [
            \App\Http\Middleware\LogLastUserActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();