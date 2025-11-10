<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class CursoService
{
    
    public function obtenerCursos()
    {
        $sql = "SELECT id_curso, titulo, descripcion, precio, estado
                FROM cursos
                WHERE estado = 'publicado'
                ORDER BY fecha_creacion DESC";
        return DB::select($sql);
    }

    public function obtenerCursoPorId($id)
    {
        $sql = "SELECT * FROM cursos WHERE id_curso = ? LIMIT 1";
        return DB::selectOne($sql, [$id]);
    }
}