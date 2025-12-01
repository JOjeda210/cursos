<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class CategoriaService
{
    public function obtenerCategorias()
    {
        $categorias = DB::table('categorias')
            ->select('id_categoria', 'nombre_categoria', 'descripcion')
            ->orderBy('nombre_categoria', 'asc')
            ->get();

        return $categorias;
    }
}
