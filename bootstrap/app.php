<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        api: __DIR__.'/../routes/api.php', // agar Laravel memuat routing API
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->group('api', [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \App\Http\Middleware\Authenticate::class,
            // \App\Http\Middleware\ForceJsonResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Jika user tidak terautentikasi, kembalikan JSON Unauthorized
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, $request) {
            return response()->json(['message' => 'Unauthorized'], 401);
        });
        
        // Jika user tidak terautentikasi atau jika route tidak ditemukan, tetap kembalikan Unauthorized (401)
        // $exceptions->render(function (\Illuminate\Auth\AuthenticationException | \Symfony\Component\Routing\Exception\RouteNotFoundException $e, $request) {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // });

        // Tangani error "Route [login] not defined"
        $exceptions->render(function (\Symfony\Component\Routing\Exception\RouteNotFoundException $e, $request) {
            return response()->json(['message' => 'Route not found'], 404);
        });
    })->withSchedule(function (Illuminate\Console\Scheduling\Schedule $schedule) {
        // hourly() Jalankan setiap jam
        // everyMinute() Jalankan setiap menit
        $schedule->job(new \App\Jobs\UpdateWeatherJob)->hourly();
    })->create();
