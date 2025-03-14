<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
// use App\Http\Middleware\Authenticate;
// use App\Http\Middleware\ForceJsonResponse;

// Definisikan rate limiter "api"
RateLimiter::for('api', function ($request) {
    return Limit::perMinute(300); // Maksimum 300 request per menit
});

// API Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    // CRUD Posts
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::patch('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);

    // GET Users
    Route::get('/users/{id}', [UserController::class, 'show']);
    
    // GET Weather
    Route::get('/weather', [WeatherController::class, 'index']);
    
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});
