<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CursoCreateController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Endpoints de auth

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);
// Esta ruta se implementará con el middleware cuando investigue como 
//Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

// Endpoints de cursos
Route::get('/cursos', [App\Http\Controllers\CursoController::class, 'index']);
Route::get('/cursos/{id}', [App\Http\Controllers\CursoController::class, 'show']);


// POC - Subir imagen de portada 
Route::post('/uploadBanner', [CursoCreateController::class, 'store']);
