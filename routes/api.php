<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CursoController; 
use App\Http\Controllers\FavoritoController; 
use App\Http\Controllers\ComentarioController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt.auth');

/// ENDPOINTS AUTH

Route::post('/register', [AuthController::class, 'register']);
Route::post('/register-instructor', [AuthController::class, 'registerInstructor']);
Route::post('/login', [AuthController::class, 'login']);

/// ENDPOINTS DE OPERACION PARA USUARIO 

// Endpoints de cursos publicos
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);

/// ENDPOINTS DE OPERACION PARA USUARIO AUTENTICADO

// Endpoints de favoritos
Route::post('/favoritos', [FavoritoController::class, 'agregarFavorito']);
Route::delete('/favoritos', [FavoritoController::class, 'eliminarFavorito']);

// Endpoints de comentarios
Route::post('/comentarios', [ComentarioController::class, 'agregarComentario']);
Route::delete('/comentarios/{id_comentario}', [ComentarioController::class, 'eliminarComentario']);


// Endpoints protegidos con JWT
Route::middleware('jwt.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/mis-cursos', [CursoController::class, 'indexMyCourses']);
    Route::post('/enroll', [CursoController::class, 'enroll']);
});


