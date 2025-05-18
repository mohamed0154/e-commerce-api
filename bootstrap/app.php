<?php

use App\Http\Middleware\AdminRoleMiddleware;
use App\Http\Middleware\UserRoleMiddleware;
use App\Http\Middleware\UserVerifiedMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminRoleMiddleware::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user-role' => UserRoleMiddleware::class,
            'user-verified' => UserVerifiedMiddleware::class,
        ]);
    })
    ->withSchedule(function (Schedule $schedule) {

        $schedule->command('queue:work')->everyMinute();
        $schedule->command('queue:restart')->everyFiveMinutes();

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
