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
        $lessons = DB::table('lecciones')
        ->select('id_leccion','titulo','tipo', 'orden', 'duracion')
        ->where('id_modulo', $idModulo)
        ->whereNull('deleted_at')
        ->orderBy('orden', 'asc')
        ->get();

        return $lessons; 

    }

    public function updateLesson($idLesson, $data, $idInstructor)
    {
        // 1. Verificación de permisos (Igual que antes)
        $isInstructorInThisCourse = DB::table('lecciones')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=','cursos.id_curso')
            ->where('lecciones.id_leccion', $idLesson)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('lecciones.id_leccion')
            ->first();

        if(!$isInstructorInThisCourse)
        {
            throw new \Exception("No tienes permiso para editar esta lección o no existe.");
        }

        $update = [];

        if (isset($data['titulo'])) {
            $update['titulo'] = $data['titulo'];
        }
        if (isset($data['orden'])) {
            $update['orden'] = $data['orden'];
        }
        if (isset($data['tipo'])) {
            $update['tipo'] = $data['tipo'];
        }

        if (array_key_exists('contenido', $data)) {
            $update['contenido'] = $data['contenido'];
        }
        if (array_key_exists('duracion', $data)) {
            $update['duracion'] = $data['duracion'];
        }

        if (!empty($update)) {
            DB::table('lecciones')
                ->where('id_leccion', $idLesson)
                ->update($update);
        }

        return true;
    }
    public function deleteLesson($idLesson, $idInstructor)
    {
        $isInstructorOwner = DB::table('lecciones')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('lecciones.id_leccion', $idLesson)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('lecciones.id_leccion')
            ->first();

        if (!$isInstructorOwner) {
            throw new \Exception("No tienes permiso para eliminar esta lección o no existe.");
        }

        DB::table('lecciones')
            ->where('id_leccion', $idLesson)
            ->update(['deleted_at' => now()]);

        return true;
    }
}