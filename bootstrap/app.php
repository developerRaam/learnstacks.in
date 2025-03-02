<?php

use App\Http\Middleware\FrontendLoginMiddleware;
use App\Http\Middleware\FrontendLogoutMiddleware;
use Illuminate\Foundation\Application;
use App\Http\Middleware\LoginMiddleware;
use App\Http\Middleware\LogoutMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'LoginMiddleware' => LoginMiddleware::class,
            'LogoutMiddleware'=> LogoutMiddleware::class,
            'FrontendLoginMiddleware' => FrontendLoginMiddleware::class,
            'FrontendLogoutMiddleware'=> FrontendLogoutMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // handle 404 page
        $exceptions->render(function (HttpException $error) {
            return response()->view('errors.404', ["error" =>$error]);
        });
    })->create();
