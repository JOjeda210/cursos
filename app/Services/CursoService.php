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
        $query = "SELECT 
                    c.titulo,
                    c.descripcion, 
                    c.imagen_portada
                  FROM cursos c
                  JOIN inscripciones i ON c.id_curso = i.id_curso
                  WHERE i.id_usuario = ?"; 
        
        $cursos = DB::select($query, [$id]);
        
        foreach ($cursos as $curso) {
            if ($curso->imagen_portada) {
                // Las imágenes están en public/cursos/
                $curso->imagen_portada = asset($curso->imagen_portada);
            } else {
                $curso->imagen_portada = 'https://via.placeholder.com/400x200';
            }
        }
        
        return $cursos;
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

    public function createCourse($data, $idInstructor)
    {
        $imgPath = $data['imagen_portada']->store('cursos', 'public');
        if($imgPath == null)
        {
            throw new \Exception('No se proporcionó la imagen al crear el curso');
        }
        $datCourse = [
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'precio' => $data['precio'],
            'imagen_portada' => $imgPath,      
            'id_categoria' => $data['id_categoria'],
            'id_instructor' => $idInstructor,  
            'estado' => 'borrador',            
            'fecha_creacion' => now()
        ]; 
        $id = DB::table('cursos')->insertGetId($datCourse);
        return DB::table('cursos')->where('id_curso', $id)->first();
    }

    public function updateCourse($idCourse,$dataUp,$idInstructor)
    {
        $course= DB::table('cursos')
            ->where('id_curso', $idCourse)
            ->where('id_instructor', $idInstructor)
            ->first();
        if(!$course)
        {
           throw new \Exception('No tienes permiso para editar este curso o no existe.'); 
        }; 
        $update = [
            'titulo' => $dataUp['titulo'],
            'descripcion' => $dataUp['descripcion'],
            'precio' => $dataUp['precio'],
            'id_categoria' => $dataUp['id_categoria'],
            'estado' => $dataUp['estado'],            
        ];
        if(isset($dataUp['imagen_portada']))
        {
            $pathImgUp = $dataUp['imagen_portada']->store('cursos', 'public'); 
            $update['imagen_portada'] = $pathImgUp;
        }
       
        DB::table('cursos')->where('id_curso', $idCourse)->update($update);
    }



}