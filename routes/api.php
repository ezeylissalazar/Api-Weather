<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\FavoriteController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/weather', [WeatherController::class, 'getWeather']);
    Route::get('/history', [WeatherController::class, 'history']);
    Route::post('/favorites', [FavoriteController::class, 'add']);
    Route::get('/favorites', [FavoriteController::class, 'list']);
    Route::delete('/favorites', [FavoriteController::class, 'remove']);
});
