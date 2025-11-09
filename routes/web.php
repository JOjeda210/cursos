<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;

Route::get('/', function () {
    return view('welcome');
});
// heathchek de db:
Route::get('/helth', [HealthController::class, 'check']);

// Retrona vista de promociones - byFlor
Route::get('/promociones', function () {
    return view('promociones');
});
// Retrona vista de catalogos - byEstefani
Route::get('/catalogos', function () {
    return view('catalogos');
});

