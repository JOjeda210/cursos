<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\InstructorController;

Route::get('/', function () {
    return view('about');
});
// heathchek de db:
Route::get('/helth', [HealthController::class, 'check']);

// Retrona vista de promociones - byFlor
Route::get('/promociones', function () {
    return view('promociones');
})->name('promociones');

// Retrona vista de catalogos - byEstefani
Route::get('/catalogos', function () {
    return view('catalogos');
})->name('catalogo');


// Retrona vista de login -byEstefani
Route::get('/login', function () {
    return view('login');
});

// Retrona vista de registro -byEstefani
Route::get('/registro', function () {
    return view('registro');
})->name('registro');

Route::get('/panel_cursos', function () {
    return view('panel_cursos');
});