<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;  
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Validator;

class FavoritoController extends Controller
{
    public function agregarFavorito(Request $request)
    {
      $validator = Validator::make($request -> all(), [
        'id_curso' => 'required|integer|exists:cursos,id_curso',
      ]);

      if($validator -> fails())
      {
        return responce() -> json(['error' => $validator -> errors()], 422);
      }

      try
      {

        $usuarioID = Auth::user() -> id_usuario;
        $cursoID = $request -> input('id_curso');

        $sql_select = "select id from favoritos where id_usuario = ? and id_curso = ?";
        $favorito = DB::select($sql_select, [$usuarioID, $cursoID]);

        if(count($favorito) > 0)
        {
            return response() -> json(['error' => 'El curso ya está en tus favoritos'], 409);
        }

        $sql_insert = "insert into favoritos (id_usuario, id_curso, created_at, updated_at) values (?, ?, now(), now())"; 
        DB::insert($sql_insert, [$usuarioID, $cursoID]);
        return response() -> json(['message' => 'Curso agregado a favoritos'], 201);
        }

        catch(\Exception $e)
        {
            Log::error('Error al agregar curso a favoritos: ' . $e -> getMessage());
            return response() -> json(['error' => 'Error al agregar curso a favoritos'], 500);
        }
    }

    public function eliminarFavorito(Request $requests)
    {
        $validator = Validator::make($request -> all(), [
            'id_curso' => 'required|integer',
        ]);

        if($validator -> fails())
        {
            return response() -> json(['error' => $validator -> errors()], 422);
        }

        try
        {
            $usuarioID = Auth::user() -> id_usuario;
            $cursoID = $request -> input('id_curso');

            $sql_select = "select id from favoritos where id_usuario = ? and id_curso = ?";
            $favorito = DB::select($sql_select, [$usuarioID, $cursoID]);

            if(count($favorito) == 0)
            {
                return response() -> json(['error' => 'El curso no está en tus favoritos'], 404);
            }

            $sql_delete = "delete from favoritos where id_usuario = ? and id_curso = ?";
            DB::delete($sql_delete, [$usuarioID, $cursoID]);

            return response() -> json(['message' => 'Curso eliminado de favoritos'], 200);
        }

        catch(\Exception $e)
        {
            Log::error('Error al eliminar curso de favoritos: ' . $e -> getMessage());
            return response() -> json(['error' => 'Error al eliminar curso de favoritos'], 500);
        }
    }
}