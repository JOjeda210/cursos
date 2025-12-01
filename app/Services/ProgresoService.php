<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class ProgresoService
{
    /**
     * Marca una lección como completada para un estudiante
     */
    public function marcarLeccionCompletada($idLeccion, $idUsuario)
    {
        // Verificar que el estudiante está inscrito en el curso de esta lección
        $inscripcion = DB::select("
            SELECT i.id_inscripcion 
            FROM inscripciones i
            INNER JOIN cursos c ON i.id_curso = c.id_curso
            INNER JOIN modulos m ON m.id_curso = c.id_curso
            INNER JOIN lecciones l ON l.id_modulo = m.id_modulo
            WHERE l.id_leccion = ? AND i.id_usuario = ?
        ", [$idLeccion, $idUsuario]);

        if (empty($inscripcion)) {
            throw new \Exception('No estás inscrito en este curso');
        }

        $idInscripcion = $inscripcion[0]->id_inscripcion;

        // Verificar si ya existe un registro de progreso
        $progresoExistente = DB::table('progreso_lecciones')
            ->where('id_inscripcion', $idInscripcion)
            ->where('id_leccion', $idLeccion)
            ->first();

        if ($progresoExistente) {
            // Actualizar a completado si no lo estaba
            if (!$progresoExistente->completado) {
                DB::table('progreso_lecciones')
                    ->where('id_progreso', $progresoExistente->id_progreso)
                    ->update([
                        'completado' => true,
                        'fecha_completado' => now()
                    ]);
            }
        } else {
            // Crear nuevo registro de progreso
            DB::table('progreso_lecciones')->insert([
                'id_inscripcion' => $idInscripcion,
                'id_leccion' => $idLeccion,
                'completado' => true,
                'fecha_completado' => now()
            ]);
        }

        // Actualizar el progreso general del curso
        $this->actualizarProgresoCurso($idInscripcion);

        return true;
    }

    /**
     * Verifica si una lección está completada
     */
    public function verificarLeccionCompletada($idLeccion, $idUsuario)
    {
        $resultado = DB::select("
            SELECT pl.completado
            FROM progreso_lecciones pl
            INNER JOIN inscripciones i ON pl.id_inscripcion = i.id_inscripcion
            WHERE pl.id_leccion = ? AND i.id_usuario = ?
        ", [$idLeccion, $idUsuario]);

        return !empty($resultado) && $resultado[0]->completado;
    }

    /**
     * Obtiene el progreso de un curso para un estudiante
     */
    public function obtenerProgresoCurso($idCurso, $idUsuario)
    {
        // Total de lecciones del curso
        $totalLecciones = DB::select("
            SELECT COUNT(*) as total
            FROM lecciones l
            INNER JOIN modulos m ON l.id_modulo = m.id_modulo
            WHERE m.id_curso = ?
        ", [$idCurso]);

        $total = $totalLecciones[0]->total ?? 0;

        // Lecciones completadas
        $leccionesCompletadas = DB::select("
            SELECT COUNT(*) as completadas
            FROM progreso_lecciones pl
            INNER JOIN inscripciones i ON pl.id_inscripcion = i.id_inscripcion
            INNER JOIN lecciones l ON pl.id_leccion = l.id_leccion
            INNER JOIN modulos m ON l.id_modulo = m.id_modulo
            WHERE m.id_curso = ? AND i.id_usuario = ? AND pl.completado = 1
        ", [$idCurso, $idUsuario]);

        $completadas = $leccionesCompletadas[0]->completadas ?? 0;

        $porcentaje = $total > 0 ? round(($completadas / $total) * 100, 2) : 0;

        return [
            'total_lecciones' => $total,
            'lecciones_completadas' => $completadas,
            'porcentaje_progreso' => $porcentaje
        ];
    }

    /**
     * Actualiza el progreso en la tabla inscripciones
     */
    private function actualizarProgresoCurso($idInscripcion)
    {
        // Obtener el curso de esta inscripción
        $inscripcion = DB::table('inscripciones')
            ->where('id_inscripcion', $idInscripcion)
            ->first();

        if (!$inscripcion) {
            return;
        }

        $progreso = $this->obtenerProgresoCurso($inscripcion->id_curso, $inscripcion->id_usuario);

        DB::table('inscripciones')
            ->where('id_inscripcion', $idInscripcion)
            ->update([
                'progreso' => $progreso['porcentaje_progreso']
            ]);
    }

    /**
     * Obtiene la siguiente lección no completada de un curso
     */
    public function obtenerSiguienteLeccion($idCurso, $idUsuario)
    {
        $resultado = DB::select("
            SELECT l.id_leccion, l.titulo, m.titulo as modulo_titulo
            FROM lecciones l
            INNER JOIN modulos m ON l.id_modulo = m.id_modulo
            LEFT JOIN progreso_lecciones pl ON l.id_leccion = pl.id_leccion
            LEFT JOIN inscripciones i ON pl.id_inscripcion = i.id_inscripcion AND i.id_usuario = ?
            WHERE m.id_curso = ?
            AND (pl.completado IS NULL OR pl.completado = 0)
            ORDER BY m.orden ASC, l.orden ASC
            LIMIT 1
        ", [$idUsuario, $idCurso]);

        return !empty($resultado) ? $resultado[0] : null;
    }
}
