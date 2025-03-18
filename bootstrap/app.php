<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->append(\App\Http\Middleware\VerifyUserAccessMiddleware::class);

        $middleware->alias([
            'yourAlias' => \App\Http\Middleware\VerifyUserAccessMiddleware::class,
        ]);

        $middleware->validateCsrfTokens(
            except: ['stripe/*']
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->dontReport(\App\Exceptions\CRMException::class);

        $exceptions->report(function (\App\Exceptions\CRMException $e) {});
    })
    ->create();
