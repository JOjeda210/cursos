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
            ->get(); 
        
        return $modules; 
    }




}