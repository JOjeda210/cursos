<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ResourceService
{
    public function createResource($data, $idInstructor)
    {

        $isOwner = DB::table('lecciones')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('lecciones.id_leccion', $data['id_leccion'])
            ->where('cursos.id_instructor', $idInstructor)
            ->exists(); 

        if (!$isOwner) {
            throw new \Exception("No tienes permiso para agregar recursos a esta lección.");
        }

        $finalUrl = null;

        if (in_array($data['tipo'], ['pdf', 'imagen'])) {
            if (isset($data['file'])) {
                $finalUrl = $data['file']->store('recursos', 'public');
            } else {
                 throw new \Exception("Debes subir un archivo para este tipo de recurso.");
            }
        } else {
            $finalUrl = $data['url'];
        }

        $resourceData = [
            'id_leccion' => $data['id_leccion'],
            'titulo' => $data['titulo'],
            'tipo' => $data['tipo'],
            'url' => $finalUrl, 
            'created_at' => now(),
            'updated_at' => now()
        ];

        $id = DB::table('recursos')->insertGetId($resourceData);
        return DB::table('recursos')->where('id_recurso', $id)->first();
    }
}