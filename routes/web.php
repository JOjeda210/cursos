<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;

Route::get('/', function () {
    return view('welcome');
});
// heathchek de db:
Route::get('/helth', [HealthController::class, 'check']);
Route::get('/promociones', function () {
    return view('promociones');
});
