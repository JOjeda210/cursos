<?php
namespace App\Services;
use Illuminate\Support\Facades\DB;

class LessonService
{
    public function createLesson($data, $idInstructor)
    {
        $isInstructorInThisCourse = DB::table('modulos')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('modulos.id_modulo', $data['id_modulo'])
            ->where('cursos.id_instructor', $idInstructor)
            ->select('modulos.id_modulo')
            ->first();
         if(!$isInstructorInThisCourse)
        {
            throw new \Exception("No tienes permiso para editar este módulo o no existe.");
        }
       $lessonData = [
            'id_modulo' => $data['id_modulo'],
            'titulo' => $data['titulo'],
            'orden' => $data['orden'],
            'tipo' => $data['tipo'],
            'contenido' => $data['contenido'] ?? null,
            'duracion' => $data['duracion'] ?? null,   
        ];
        $id = DB::table('lecciones')->insertGetId($lessonData);
        return DB::table('lecciones')->where('id_leccion', $id)->first();
    }
    
    public function getLessonsByModule($idModulo)
    {
        
    }
}