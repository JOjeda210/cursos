<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class PlayerService
{
    public function getCourseContent($idCurso, $idEstudiante)
    {
  
        $inscripcion = DB::table('inscripciones')
            ->where('id_curso', $idCurso)
            ->where('id_usuario', $idEstudiante)
            // ->where('estado', 'activo') 
            ->first();

        if (!$inscripcion) {
            $isInstructorOwner = DB::table('cursos')
                ->where('id_curso', $idCurso)
                ->where('id_instructor', $idEstudiante)
                ->exists();
            
            if (!$isInstructorOwner) {
                throw new \Exception("No tienes acceso a este curso. Debes inscribirte primero.", 403);
            }
        }

        
        $modules = DB::table('modulos')
            ->where('id_curso', $idCurso)
            ->whereNull('deleted_at')
            ->orderBy('orden', 'asc')
            ->get();

        $modulesIds = $modules->pluck('id_modulo')->toArray();
        $lessons = DB::table('lecciones')
            ->whereIn('id_modulo', $modulesIds)
            ->whereNull('deleted_at')
            ->orderBy('orden', 'asc')
            ->get();

        $lessonsIds = $lessons->pluck('id_leccion')->toArray();
        $resources = DB::table('recursos')
            ->whereIn('id_leccion', $lessonsIds)
            ->whereNull('deleted_at')
            ->get();

        // Esto estructura la data para que el Frontend la consuma fácil
        foreach ($modules as $mod) {
            // Asignamos las lecciones a este módulo
            $mod->lecciones = $lessons->where('id_modulo', $mod->id_modulo)->values();
            
            foreach ($mod->lecciones as $less) {
                // Asignamos los recursos a esta lección
                $less->recursos = $resources->where('id_leccion', $less->id_leccion)->values();
            }
        }

        return $modules;
    }
}