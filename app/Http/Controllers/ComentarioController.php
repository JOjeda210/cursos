<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ComentarioController extends Controller
{
    public function crear(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'id_curso' => 'required|integer|exists:cursos,id_curso',
            'contenido' => 'required|string|max:1000',
        ]);

        if($validator -> fails())
        {
            return response() -> json(['error' => $validator -> errors()], 422);
        }

        try
        {
            $usuarioID = Auth::user() -> id_usuario;
            $cursoID = $request -> input('id_curso');
            $contenido = $request -> input('contenido');

            $sql_insert = "insert into comentarios (id_usuario, id_curso, contenido, created_at, updated_at) values (?, ?, ?, now(), now())"; 
            DB::insert($sql_insert, [$usuarioID, $cursoID, $contenido]);
            return response() -> json(['message' => 'Comentario creado exitosamente'], 201);
        }
        catch(\Exception $e)
        {
            Log::error('Error al crear comentario: ' . $e -> getMessage());
            return response() -> json(['error' => 'Error al crear comentario'], 500);
        }
    }
}