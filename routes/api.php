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

/// ENDPOINTS API REST AUTH


// Endpoints de auth
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/// ENDPOINTS DE OPERACION 

// Endpoints de cursos
Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index']);
Route::get('/cursos/{id}', [App\Http\Controllers\CursoController::class, 'show']);

// Endpoints de favoritos
//Route::middleware('auth:sanctum') -> group(function () 
//{
    Route::post('/favoritos', [FavoritoController::class, 'agregarFavorito']);
    Route::delete('/favoritos', [FavoritoController::class, 'eliminarFavorito']);
//});

// Endpoints de comentarios
Route::post('/comentarios', [ComentarioController::class, 'crear']);
Route::delete('/comentarios/{id_comentario}', [ComentarioController::class, 'eliminar']);
// Endpoints de cursos públicos
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);

// Endpoints protegidos con JWT
Route::middleware('jwt.auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/mis-cursos', [CursoController::class, 'indexMyCourses']);
    Route::post('/enroll', [CursoController::class, 'enroll']);
});

Route::post('/comentarios', [ComentarioController::class, 'agregarComentario']);
Route::delete('/comentarios/{id_comentario}', [ComentarioController::class, 'eliminarComentario']);
