<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;

Route::get('/', function () {
    return view('welcome');
});
// heathchek de db:
Route::get('/helth', [HealthController::class, 'check']); 


// Endpoints de auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);