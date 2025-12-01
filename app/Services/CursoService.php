<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class CursoService
{
    
    public function obtenerCursos($userId = null)
    {
        $sql = "SELECT 
                    c.id_curso, 
                    c.titulo, 
                    c.descripcion, 
                    c.precio, 
                    c.estado,
                    c.imagen_portada,
                    cat.nombre_categoria
                FROM cursos c
                LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria
                WHERE c.estado = 'publicado'
                ORDER BY c.fecha_creacion DESC";
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
                    c.id_curso,
                    c.titulo,
                    c.descripcion, 
                    c.imagen_portada,
                    c.precio,
                    c.estado,
                    i.progreso,
                    i.fecha_inscripcion,
                    cat.nombre_categoria
                  FROM cursos c
                  JOIN inscripciones i ON c.id_curso = i.id_curso
                  LEFT JOIN categorias cat ON c.id_categoria = cat.id_categoria
                  WHERE i.id_usuario = ?
                  ORDER BY i.fecha_inscripcion DESC"; 
        
        $cursos = DB::select($query, [$id]);
        
        foreach ($cursos as $curso) {
            if ($curso->imagen_portada) {
                // No usar asset() porque ya tiene la ruta completa
                $curso->imagen_url = '/storage/' . $curso->imagen_portada;
            } else {
                $curso->imagen_url = 'https://via.placeholder.com/400x200';
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
        $imgPath = null;
        
        // Solo procesar imagen si se proporciona
        if(isset($data['imagen_portada']) && $data['imagen_portada'] !== null)
        {
            $imgPath = $data['imagen_portada']->store('cursos', 'public');
        }
        
        // Asegurar que el precio sea un número válido
        $precio = isset($data['precio']) && $data['precio'] !== null && $data['precio'] !== '' 
                  ? (float) $data['precio'] 
                  : 0.00;
        
        $datCourse = [
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'precio' => $precio,
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

    public function removeCourse($idCourse,$idInstructor)
    {
         $course= DB::table('cursos')
            ->where('id_curso', $idCourse)
            ->where('id_instructor', $idInstructor)
            ->first();
        if(!$course)
        {
           throw new \Exception('No tienes permiso para editar este curso o no existe.'); 
        }; 
       DB::table('cursos')
            ->where('id_curso', $idCourse)
            ->update(['estado' => 'eliminado']);

        return true;
        
    }

    public function getInstructorCourses($idInstructor)
    {
        $courses = DB::table('cursos')
            ->select('id_curso','titulo','imagen_portada','descripcion','precio','estado','id_categoria')
            ->where('id_instructor', $idInstructor)
            ->where('estado', '!=', 'eliminado')
            ->orderBy('fecha_creacion', 'desc')
            ->get(); 
        
        return $courses; 
    }

    public function publishCourse($idCourse, $idInstructor)
    {
        // Verificar que el curso pertenece al instructor
        $course = DB::table('cursos')
            ->where('id_curso', $idCourse)
            ->where('id_instructor', $idInstructor)
            ->first();

        if (!$course) {
            throw new \Exception('No tienes permiso para publicar este curso o no existe.');
        }

        if ($course->estado === 'publicado') {
            throw new \Exception('El curso ya está publicado.');
        }

        // Verificar que el curso tiene al menos un módulo
        $modulosCount = DB::table('modulos')
            ->where('id_curso', $idCourse)
            ->whereNull('deleted_at')
            ->count();

        if ($modulosCount === 0) {
            throw new \Exception('El curso debe tener al menos un módulo para poder ser publicado.');
        }

        // Verificar que el curso tiene al menos una lección
        $leccionesCount = DB::table('lecciones')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->where('modulos.id_curso', $idCourse)
            ->whereNull('lecciones.deleted_at')
            ->whereNull('modulos.deleted_at')
            ->count();

        if ($leccionesCount === 0) {
            throw new \Exception('El curso debe tener al menos una lección para poder ser publicado.');
        }

        // Publicar el curso
        DB::table('cursos')
            ->where('id_curso', $idCourse)
            ->update([
                'estado' => 'publicado',
                'fecha_publicacion' => now()
            ]);

        return true;
    }

    public function obtenerCursoCompleto($id)
    {
        // Obtener información básica del curso
        $curso = DB::table('cursos as c')
            ->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')
            ->select('c.*', 'cat.nombre_categoria')
            ->where('c.id_curso', $id)
            ->first();

        if (!$curso) {
            return null;
        }

        // Obtener módulos del curso
        $modulos = DB::table('modulos')
            ->where('id_curso', $id)
            ->whereNull('deleted_at')
            ->orderBy('orden')
            ->get();

        // Obtener lecciones para cada módulo
        foreach ($modulos as $modulo) {
            $modulo->lecciones = DB::table('lecciones')
                ->where('id_modulo', $modulo->id_modulo)
                ->orderBy('orden')
                ->get();
        }

        // Estadísticas
        $curso->modulos = $modulos;
        $curso->totalModulos = $modulos->count();
        $curso->totalLecciones = 0;
        foreach ($modulos as $modulo) {
            $curso->totalLecciones += count($modulo->lecciones);
        }

        $curso->totalInscripciones = DB::table('inscripciones')
            ->where('id_curso', $id)
            ->count();

        return $curso;
    }

    public function obtenerCursoParaEstudiante($idCurso, $idUsuario)
    {
        // Verificar inscripción
        $inscripcion = DB::table('inscripciones')
            ->where('id_usuario', $idUsuario)
            ->where('id_curso', $idCurso)
            ->first();

        if (!$inscripcion) {
            return null;
        }

        // Obtener información del curso
        $curso = DB::table('cursos as c')
            ->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')
            ->leftJoin('usuarios as u', 'c.id_instructor', '=', 'u.id_usuario')
            ->select(
                'c.*',
                'cat.nombre_categoria',
                'u.nombre as instructor_nombre',
                'u.apellido as instructor_apellido'
            )
            ->where('c.id_curso', $idCurso)
            ->where('c.estado', 'publicado')
            ->first();

        if (!$curso) {
            return null;
        }

        // Obtener módulos
        $modulos = DB::table('modulos')
            ->where('id_curso', $idCurso)
            ->whereNull('deleted_at')
            ->orderBy('orden')
            ->get();

        // Obtener lecciones y recursos para cada módulo
        foreach ($modulos as $modulo) {
            $modulo->lecciones = DB::table('lecciones')
                ->where('id_modulo', $modulo->id_modulo)
                ->orderBy('orden')
                ->get();

            foreach ($modulo->lecciones as $leccion) {
                // Obtener recursos
                $leccion->recursos = DB::table('recursos')
                    ->where('id_leccion', $leccion->id_leccion)
                    ->get();
                
                // Verificar si la lección está completada
                $progresoLeccion = DB::table('progreso_lecciones')
                    ->where('id_inscripcion', $inscripcion->id_inscripcion)
                    ->where('id_leccion', $leccion->id_leccion)
                    ->first();
                
                $leccion->completada = $progresoLeccion && $progresoLeccion->completado ? true : false;
            }
        }

        // Estadísticas
        $curso->modulos = $modulos;
        $curso->totalModulos = $modulos->count();
        $curso->totalLecciones = 0;
        foreach ($modulos as $modulo) {
            $curso->totalLecciones += count($modulo->lecciones);
        }

        // Calcular progreso
        $leccionesCompletadas = DB::table('progreso_lecciones as pl')
            ->join('lecciones as l', 'pl.id_leccion', '=', 'l.id_leccion')
            ->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')
            ->where('m.id_curso', $idCurso)
            ->where('pl.id_inscripcion', $inscripcion->id_inscripcion)
            ->where('pl.completado', true)
            ->count();

        $curso->progresoCalculado = $curso->totalLecciones > 0 
            ? ($leccionesCompletadas / $curso->totalLecciones) * 100 
            : 0;
        $curso->leccionesCompletadas = $leccionesCompletadas;
        $curso->inscripcion = $inscripcion;

        return $curso;
    }


}