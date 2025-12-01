<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller
{
    public function index()
    {
        try {
            $categorias = DB::table('categorias')
                ->select('id_categoria', 'nombre_categoria', 'descripcion')
                ->orderBy('nombre_categoria', 'asc')
                ->get();

            return response()->json($categorias, 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al obtener categorías',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}