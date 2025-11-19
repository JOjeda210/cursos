<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\PrivadosController;

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

// Comentarios - Flor
Route::post('/comentarios', [ComentariosController::class, 'store'])
    ->name('comentarios.store');

//  NUEVA RUTA: Cursos Privados (solo usuarios logueados)
// Route::middleware(['auth'])->get('/cursos-privados', [PrivadosController::class, 'index'])
//     ->name('cursos.privados');
// Endpoint comentarios fake:
Route::post('/comentarios', [ComentariosController::class, 'store'])->name('comentarios.store');

Route::get('/mis-cursos', function () {
    return view('mis-cursos');
})->name('misCursos');
