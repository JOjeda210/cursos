<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProgresoService;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LeccionController extends Controller
{
    protected $progresoService;

    public function __construct(ProgresoService $progresoService)
    {
        $this->progresoService = $progresoService;
    }

    /**
     * Vista de lección individual
     */
    public function verLeccion($idCurso, $idLeccion)
    {
        return view('ver_leccion', [
            'id_curso' => $idCurso,
            'id_leccion' => $idLeccion
        ]);
    }

    /**
     * API: Obtener datos de una lección
     */
    public function obtenerDatosLeccion($idLeccion)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json(['error' => 'No autenticado'], 401);
            }

            // Obtener datos de la lección
            $leccion = DB::table('lecciones as l')
                ->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')
                ->join('cursos as c', 'm.id_curso', '=', 'c.id_curso')
                ->where('l.id_leccion', $idLeccion)
                ->select(
                    'l.id_leccion',
                    'l.titulo',
                    'l.contenido',
                    'l.duracion',
                    'l.tipo',
                    'l.orden as leccion_orden',
                    'm.id_modulo',
                    'm.titulo as modulo_titulo',
                    'm.orden as modulo_orden',
                    'c.id_curso',
                    'c.titulo as curso_titulo'
                )
                ->first();

            if (!$leccion) {
                return response()->json(['error' => 'Lección no encontrada'], 404);
            }

            // Verificar que el estudiante está inscrito
            $inscrito = DB::table('inscripciones')
                ->where('id_curso', $leccion->id_curso)
                ->where('id_usuario', $user->id_usuario)
                ->exists();

            if (!$inscrito) {
                return response()->json(['error' => 'No estás inscrito en este curso'], 403);
            }

            // Obtener recursos de la lección (puede estar vacío)
            $recursos = DB::table('recursos')
                ->where('id_leccion', $idLeccion)
                ->whereNull('deleted_at')
                ->select('id_recurso', 'tipo', 'titulo', 'url')
                ->get();
            
            // Convertir a array para asegurar que siempre sea iterable
            $recursos = $recursos ? $recursos->toArray() : [];

            // Verificar si está completada
            $completada = $this->progresoService->verificarLeccionCompletada($idLeccion, $user->id_usuario);

            // Obtener lección anterior y siguiente
            $leccionAnterior = DB::select("
                SELECT l.id_leccion, l.titulo
                FROM lecciones l
                INNER JOIN modulos m ON l.id_modulo = m.id_modulo
                WHERE m.id_curso = ?
                AND (
                    m.orden < ? OR 
                    (m.orden = ? AND l.orden < ?)
                )
                ORDER BY m.orden DESC, l.orden DESC
                LIMIT 1
            ", [$leccion->id_curso, $leccion->modulo_orden, $leccion->modulo_orden, $leccion->leccion_orden]);

            $leccionSiguiente = DB::select("
                SELECT l.id_leccion, l.titulo
                FROM lecciones l
                INNER JOIN modulos m ON l.id_modulo = m.id_modulo
                WHERE m.id_curso = ?
                AND (
                    m.orden > ? OR 
                    (m.orden = ? AND l.orden > ?)
                )
                ORDER BY m.orden ASC, l.orden ASC
                LIMIT 1
            ", [$leccion->id_curso, $leccion->modulo_orden, $leccion->modulo_orden, $leccion->leccion_orden]);

            $leccion->recursos = $recursos;
            $leccion->completada = $completada;
            $leccion->leccion_anterior = !empty($leccionAnterior) ? $leccionAnterior[0] : null;
            $leccion->leccion_siguiente = !empty($leccionSiguiente) ? $leccionSiguiente[0] : null;

            return response()->json($leccion, 200);

        } catch (\Exception $e) {
            Log::error('Error en obtenerDatosLeccion: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'error' => 'Error al cargar la lección',
                'message' => $e->getMessage(),
                'trace' => config('app.debug') ? $e->getTraceAsString() : null
            ], 500);
        }
    }

    /**
     * API: Marcar lección como completada
     */
    public function completarLeccion($idLeccion)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json(['error' => 'No autenticado'], 401);
            }

            $this->progresoService->marcarLeccionCompletada($idLeccion, $user->id_usuario);

            // Obtener datos de la lección para devolver info del curso
            $leccion = DB::table('lecciones as l')
                ->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')
                ->where('l.id_leccion', $idLeccion)
                ->select('m.id_curso')
                ->first();

            if ($leccion) {
                $progreso = $this->progresoService->obtenerProgresoCurso($leccion->id_curso, $user->id_usuario);
            } else {
                $progreso = null;
            }

            return response()->json([
                'success' => true,
                'message' => '¡Lección completada!',
                'progreso' => $progreso
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al completar la lección',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
