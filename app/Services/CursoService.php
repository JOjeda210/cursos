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

    public function getMyCourses($id)
    {
        $query = " SELECT titulo,descripcion, imagen_portada 
                    FROM cursos c
                    JOIN inscripciones i ON c.id_curso = i.id_curso
                    WHERE i.id_usuario = ?"; 
                            
        return DB::select($query,[$id]);
    }

    public function enRoll($idUser, $idCourse)
    {
        $course = $this->obtenerCursoPorId($idCourse); 
        if($course->estado != 'publicado')
        {
            throw new \Exception('Este curso no está disponible para inscripción.');
        }

        $queryUserEnroll = "SELECT * 
                            FROM inscripciones
                            WHERE id_curso = ? AND id_usuario = ?
                            LIMIT 1" ; 
                            
        $enrollExist = DB::selectOne($queryUserEnroll,[$idCourse,$idUser]); 
        if($enrollExist)
        {
            throw new \Exception('Ya estás inscrito en este curso.');
        }
        $queryEnroll = "INSERT INTO inscripciones (id_usuario,id_curso,fecha_inscripcion,progreso,estado)
                        VALUES (?,?,?,?,?)"; 
        DB::insert($queryEnroll,[$idUser,$idCourse,now(),0,'en_curso']); 

          
    }




}