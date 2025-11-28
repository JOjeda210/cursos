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

        $url = null;

        if (in_array($data['tipo'], ['pdf', 'imagen'])) {
            if (isset($data['file'])) {
                $url = $data['file']->store('recursos', 'public');
            }
        } else {
            $url = $data['url'] ?? null;
        }

        $id = DB::table('recursos')->insertGetId([
            'id_leccion' => $data['id_leccion'],
            'titulo' => $data['titulo'],
            'tipo' => $data['tipo'],
            'url' => $url,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return DB::table('recursos')->where('id_recurso', $id)->first();
    }

    public function getResourcesByLesson($idLeccion)
    {
        return DB::table('recursos')
            ->where('id_leccion', $idLeccion)
            ->whereNull('deleted_at') 
            ->get();
    }

    public function updateResource($idRecurso, $data, $idInstructor)
    {
        $resource = DB::table('recursos')
            ->join('lecciones', 'recursos.id_leccion', '=', 'lecciones.id_leccion')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('recursos.id_recurso', $idRecurso)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('recursos.*') 
            ->first();

        if (!$resource) {
            throw new \Exception("No tienes permiso o el recurso no existe.");
        }

        $updateData = ['updated_at' => now()];

        if (isset($data['titulo'])) $updateData['titulo'] = $data['titulo'];
        

        if (isset($data['tipo'])) {
            $updateData['tipo'] = $data['tipo'];
        }

        if (in_array($data['tipo'] ?? $resource->tipo, ['pdf', 'imagen'])) {
            if (isset($data['file'])) {
                if ($resource->url && Storage::disk('public')->exists($resource->url)) {
                    Storage::disk('public')->delete($resource->url);
                }
                $updateData['url'] = $data['file']->store('recursos', 'public');
            }
        } else {
            if (isset($data['url'])) {
                $updateData['url'] = $data['url'];
            }
        }

        DB::table('recursos')->where('id_recurso', $idRecurso)->update($updateData);

        return true;
    }

    public function deleteResource($idRecurso, $idInstructor)
    {
        $resource = DB::table('recursos')
            ->join('lecciones', 'recursos.id_leccion', '=', 'lecciones.id_leccion')
            ->join('modulos', 'lecciones.id_modulo', '=', 'modulos.id_modulo')
            ->join('cursos', 'modulos.id_curso', '=', 'cursos.id_curso')
            ->where('recursos.id_recurso', $idRecurso)
            ->where('cursos.id_instructor', $idInstructor)
            ->select('recursos.id_recurso')
            ->first();

        if (!$resource) {
            throw new \Exception("No tienes permiso para eliminar este recurso.");
        }

        DB::table('recursos')
            ->where('id_recurso', $idRecurso)
            ->update(['deleted_at' => now()]);

        return true;
    }
}