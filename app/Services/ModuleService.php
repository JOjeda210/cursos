<?php

namespace App\Services;
use Illuminate\Support\Facades\DB;

class ModuleService
{
    public function createModule($data, $idInstructor)
    {
        // Validacion por logica de negocio
        $course = DB::table('cursos')
            ->where('id_curso',$data['id_curso'])
            ->where('id_instructor', $idInstructor)
            ->first();
        if(!$course)
        {
            throw new \Exception("No tienes permiso para agregar módulos a este curso.");
        }
        $datModule = [
            'id_curso' => $data['id_curso'], 
            'titulo' => $data['titulo'], 
            'orden' => $data['orden']
        ];
        $newModule = DB::table('modulos')->insertGetId($datModule); 
        return DB::table('modulos')->where('id_modulo', $newModule)->first();
        
    }

    public function getModulesByCourse($idCurso)
    {
       
        $modules = DB::table('modulos')
            ->select('id_modulo','id_curso','titulo','orden')
            ->where('id_curso', $idCurso)
            ->orderBy('orden', 'asc')
            ->whereNull('deleted_at')
            ->get(); 
        
        return $modules; 
    }

    public function updateModule($idModulo, $data, $idInstructor)
    {
        // validacion para modulo - instructor
        $isInstructorInThisCourse = DB::table('modulos')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('modulos.id_modulo', $idModulo)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('modulos.id_modulo')
            ->first();
        if(!$isInstructorInThisCourse)
        {
            throw new \Exception("No tienes permiso para editar este módulo o no existe.");
        }
        $upModule = [
            'titulo' => $data['titulo'],
            'orden' => $data['orden'],
        ];
        $UpModuleResponde = DB::table('modulos')
            ->where('id_modulo',$idModulo)
            -> update($upModule); 
        return $UpModuleResponde; 
    }

    public function deleteModule($idModulo,$idInstructor)
    {
         $isInstructorInThisCourse = DB::table('modulos')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('modulos.id_modulo', $idModulo)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('modulos.id_modulo')
            ->first();
        if(!$isInstructorInThisCourse)
        {
            throw new \Exception("No tienes permiso para eliminar este módulo o no existe.");
        }
         DB::table('modulos')
            ->where('id_modulo', $idModulo)
            ->update(['deleted_at' => now()]);

        return true;

    }



}