<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\PrivadosController;

// Vista principal
Route::get('/', function () {
    return view('about');
});

// healthcheck
Route::get('/helth', [HealthController::class, 'check']);

// Promociones - Flor
Route::get('/promociones', function () {
    return view('promociones');
})->name('promociones');

// Catálogo público - Estefani
Route::get('/catalogos', function () {
    return view('catalogos');
})->name('catalogo');

// Login - Estefani
Route::get('/login', function () {
    return view('login');
});

// Registro - Estefani
Route::get('/registro', function () {
    return view('registro');
})->name('registro');

// Comentarios - Flor
Route::post('/comentarios', [ComentariosController::class, 'store'])
    ->name('comentarios.store');

//  NUEVA RUTA: Cursos Privados (solo usuarios logueados)
Route::middleware(['auth'])->get('/cursos-privados', [PrivadosController::class, 'index'])
    ->name('cursos.privados');
