<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\ComentariosController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\PrivadosController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\CursoController;


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

// Registro Instructor
Route::get('/registro-instructor', function () {
    return view('client.registro-instructor');
})->name('registro.instructor');


/////// ENDPOINTS PRIVADOS

// Comentarios(Modal solo aparece con JWT en localstorage) - Flor
Route::post('/comentarios', [ComentarioController::class, 'agregarComentario']) ->name('comentarios.store');
   

// Catálogo Privado (requiere JWT en localStorage)
Route::get('/catalogo-privado', function () {
    return view('catalogo-private');
})->name('catalogo.privado');


// Catálogo MIS CURSOS
Route::get('/mis-cursos', function () {
    return view('mis-cursos');
})->name('misCursos')->middleware('web.jwt');

// Panel Instructor (Cursos)
Route::get('/panel-instructor', function () {
    return view('panel_cursos');
})->name('panel.instructor')->middleware('web.jwt');

// Crear Módulo
Route::get('/panel-instructor/modulos', function () {
    return view('panel_modulos');
})->name('panel.modulos')->middleware('web.jwt');

// Lecciones y Recursos
Route::get('/panel-instructor/lecciones', function () {
    return view('lecciones');
})->name('panel.lecciones')->middleware('web.jwt');

// Ver Curso (Instructor)
Route::get('/panel-instructor/cursos/{id}', [CursoController::class, 'verCurso'])
    ->name('curso.ver')
    ->middleware('web.jwt');

// Gestión de Recursos
Route::get('/panel-instructor/recursos', function () {
    return view('panel_recursos');
})->name('panel.recursos')->middleware('web.jwt');

// Ver Curso (Estudiante)
Route::get('/mis-cursos/{id}', [CursoController::class, 'verCursoEstudiante'])
    ->name('curso.estudiante')
    ->middleware('web.jwt');
