<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
// Importe o middleware
use App\Http\Middleware\UpdateUserActivity;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Adicione esta linha para registrar o middleware no grupo 'web'
        $middleware->web(append: [
            UpdateUserActivity::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();