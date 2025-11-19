<?php
namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FavoritoService
{
    public function agregarFavorito($usuarioID, $cursoID)
    {
        try
        {
            $sql_select = "select id from favoritos where id_usuario = ? and id_curso = ?";
            $favorito = DB::select($sql_select, [$usuarioID, $cursoID]);

            if(count($favorito) > 0)
            {
                return ['error' => 'El curso ya está en tus favoritos', 'status' => 409];
            }

            $sql_insert = "insert into favoritos (id_usuario, id_curso, created_at, updated_at) values (?, ?, now(), now())"; 
            DB::insert($sql_insert, [$usuarioID, $cursoID]);
            return ['message' => 'Curso agregado a favoritos', 'status' => 201];
        }

        catch(\Exception $e)
        {
            Log::error('Error al agregar curso a favoritos: ' . $e -> getMessage());
            return ['error_real' => $e -> getMessage(), 'status' => 500];
        }
    }

    public function eliminarFavorito($usuarioID, $cursoID)
    {
        try
        {
            $sql_select = "select from favoritos where id_usuario = ? and id_curso = ?";
            $favorito = DB::select($sql_select, [$usuarioID, $cursoID]);

            if(count($favorito) == 0)
            {
                return ['error' => 'El curso no está en tus favoritos', 'status' => 404];
            }

            $sql_delete = "delete from favoritos where id_usuario = ? and id_curso = ?";
            $delete = DB::delete($sql_delete, [$usuarioID, $cursoID]);

            return ['message' => 'Curso eliminado de favoritos', 'status' => 200];
        }

        catch(\Exception $e)
        {
            Log::error('Error al eliminar curso de favoritos: ' . $e -> getMessage());
            return ['error_real' => $e -> getMessage(), 'status' => 500];
        }
    }
}