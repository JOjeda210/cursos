<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// 1. Crear la rama
// 2. Modificar la rama (realizar cambios)
// 3. Subir la rama al repositorio remoto