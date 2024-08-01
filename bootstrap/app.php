<?php

use App\Http\Controllers\AuthController;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
    //api: __DIR__.'/../routes/api.php',
        using: function () {
            Route::group([

                'middleware' => 'api',
                'prefix' => 'auth'

            ], function ($router) {

                Route::post('login', [AuthController::class, 'login'])->name('login');
                Route::post('logout', [AuthController::class, 'logout']);
                Route::post('refresh', [AuthController::class, 'refresh']);
                Route::post('register', [AuthController::class, 'register']);
            });
            Route::group([
                'middleware' => 'api',
                'prefix' => 'users'
            ], function ($router) {
                Route::post('profile', [AuthController::class, 'profile']);
            });


        },
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

