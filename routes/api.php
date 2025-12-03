<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CursoController; 
use App\Http\Controllers\FavoritoController; 
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\Api\ModuleController;
use App\Http\Controllers\Api\LessonController;
use App\Http\Controllers\Api\ResourceController;
use App\Http\Controllers\Api\PlayerController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('jwt.auth');

/// ENDPOINTS AUTH

Route::post('/register', [AuthController::class, 'register']);
// Aqui se validará el registro para el instructor
Route::post('/register-instructor', [AuthController::class, 'registerInstructor']);
Route::post('/login', [AuthController::class, 'login']);

/// ENDPOINTS DE OPERACION PARA USUARIO 

// Endpoints de cursos publicos
Route::get('/cursos', [CursoController::class, 'index']);
Route::get('/cursos/{id}', [CursoController::class, 'show']);

// Endpoint de categorías (público para formularios)
Route::get('/categorias', [\App\Http\Controllers\Api\CategoriaController::class, 'index']);

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
    
    // Obtener datos del curso para estudiante
    Route::get('/mis-cursos/{id}/datos', [CursoController::class, 'obtenerCursoEstudiante']);
    
    // Rutas para lecciones de estudiantes
    Route::get('/lecciones/{id}/datos', [\App\Http\Controllers\LeccionController::class, 'obtenerDatosLeccion']);
    Route::post('/lecciones/{id}/completar', [\App\Http\Controllers\LeccionController::class, 'completarLeccion']);
    
    // Rutas CRUD CURSOS Admin - 
    Route::get('/instructor/cursos',[CursoController::class, 'indexCoursesInstructor']);
    Route::post('/instructor/cursos',[CursoController::class, 'storeCourseInstructor']);
    Route::put('/instructor/cursos/{id}',[CursoController::class, 'updateCourseInstructor']);
    Route::delete('/instructor/cursos/{id}',[CursoController::class, 'destroyCoursesInstructor']);
    Route::patch('/instructor/cursos/{id}/publicar',[CursoController::class, 'publishCourse']);

    // Rutas CRUD MODULOS Admin - 
    Route::get('/instructor/modulos/{id}',[ModuleController::class,'indexModules']);
    Route::post('/instructor/modulos',[ModuleController::class,'storeModule']);
    Route::put('/instructor/modulos/{id}',[ModuleController::class,'updateModule']);
    Route::delete('/instructor/modulos/{id}',[ModuleController::class,'destroyModule']);

    // Rutas CRUD LECCIONES Admin - 
    Route::get('/modulos/{id}/lecciones', [LessonController::class, 'indexLessons']);
    Route::post('/lecciones', [LessonController::class, 'storeLesson']);
    Route::put('/lecciones/{id}', [LessonController::class, 'updateLesson']);
    Route::delete('/lecciones/{id}', [LessonController::class, 'destroyLesson']);

    // Rutas CRUD RECURSOS Admin - 
    Route::get('/leccions/{id}/recursos', [ResourceController::class, 'indexResource']);
    Route::post('/recursos', [ResourceController::class, 'storeResource']);
    Route::post('/recursos/{id}', [ResourceController::class, 'updateResource']); 
    Route::delete('/recursos/{id}', [ResourceController::class, 'destroyResource']);

    // Ruta para el usuario 
    Route::get('/player/curso/{id}', [PlayerController::class, 'getCourseContent']);
});
