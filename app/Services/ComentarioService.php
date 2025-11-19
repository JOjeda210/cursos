<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ComentarioService
{
    public function agregarComentario(int $usuarioID, int $cursoID, string $contenido)
    {
        try
        {
            $sql_insert = "insert into comentarios (id_usuario, id_curso, contenido, fecha_comentario) values (?, ?, ?, now())"; 
            DB::insert($sql_insert, [$usuarioID, $cursoID, $contenido]);

            return ['message' => 'Comentario agregado exitosamente', 'status' => 201];
        }

        catch(\Exception $e)
        {
            Log::error('Error al agregar comentario: ' . $e -> getMessage());
            return ['error_real' => $e -> getMessage(), 'status' => 500];
        }
    }

    public function eliminarComentario(int $usuarioID, int $comentarioID)
    {
        try
        {
            $sql_find = "select id_usuario from comentarios where id_comentario = ?";
            $comentario = DB::selectOne($sql_find, [$comentarioID]);

            if(!$comentario)
            {
                return ['error' => 'Comentario no encontrado', 'status' => 404];
            }

            if($comentario -> id_usuario != $usuarioID)
            {
                return ['error' => 'Comentario no encontrado', 'status' => 403];
            }

            $sql_delete = "delete from comentarios where id_comentario = ?";
            DB::delete($sql_delete, [$comentarioID]);

            return ['message' => 'Comentario eliminado exitosamente', 'status' => 200];
        }

        catch(\Exception $e)
        {
            Log::error('Error al eliminar comentario: ' . $e -> getMessage());
            return ['error_real' => $e -> getMessage(), 'status' => 500];
        }
    }
}