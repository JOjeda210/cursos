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

            $sql_insert = "insert into comentarios (id_usuario, id_curso, contenido, fecha_comentario) values (?, ?, ?, now())"; 
            DB::insert($sql_insert, [$usuarioID, $cursoID, $contenido]);
            return response() -> json(['message' => 'Comentario creado exitosamente'], 201);
        }
        catch(\Exception $e)
        {
            Log::error('Error al crear comentario: ' . $e -> getMessage());
            return response() -> json(['error_real' => $e -> getMessage()], 500);
        }
    }

    public function eliminar(Request $request, $id_comentario)
    {
        try
        {
            $usuarioID = Auth::user() -> id_usuario;
            $sql_find = "select id_usuario from comentarios where id_comentario = ?";
            $comentario = DB::selectOne($sql_find, [$id_comentario]);

            if(!$comentario)
            {
                return response() -> json(['error' => 'Comentario no encontrado'], 404);
            }

            if($comentario -> id_usuario != $usuarioID)
            {
                return response() -> json(['error' => 'No tienes permiso para eliminar este comentario'], 403);
            }

            $sql_delete = "delete from comentarios where id_comentario = ?";
            DB::delete($sql_delete, [$id_comentario]);
            return response() -> json(['message' => 'Comentario eliminado exitosamente'], 200);
        }

        catch(\Exception $e)
        {
            Log::error('Error al eliminar comentario: ' . $e -> getMessage());
            return response() -> json(['error_real' => $e -> getMessage()], 500);
        }
    }
}