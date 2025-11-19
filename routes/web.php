<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\PrivadosController;


/////// ENDPOINTS PUBLICOS
// Vista principal
Route::get('/', function () {
    return view('client.about');
});

// healthcheck
Route::get('/helth', [HealthController::class, 'check']);

// Promociones - Flor
Route::get('/promociones', function () {
    return view('client.promociones');
})->name('promociones');

// Catálogo público - Estefani
Route::get('/catalogos', function () {
    return view('client.catalogo-publico');
})->name('catalogo');

// Login - Estefani
Route::get('/login', function () {
    return view('client.login');
});

// Registro - Estefani
Route::get('/registro', function () {
    return view('client.registro');
})->name('registro');


/////// ENDPOINTS PRIVADOS

// Comentarios(Modal solo aparece con JWT en localstorage) - Flor
Route::post('/comentarios', [ComentariosController::class, 'store'])
    ->name('comentarios.store');

// Catálogo Privado (requiere JWT en localStorage)
Route::get('/catalogo-privado', function () {
    return view('catalogo-private');
})->name('catalogo.privado');

// Endpoint comentarios fake:
Route::post('/comentarios', [ComentariosController::class, 'store'])->name('comentarios.store');

// Catálogo MIS CURSOS
Route::get('/mis-cursos', function () {
    return view('mis-cursos');
})->name('misCursos');
