<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\EnrollRequest;
use App\Http\Requests\Courses\UpdateCourseRequest;
use App\Http\Requests\Courses\StoreCourseRequest;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    protected $cursoService, $_authService;
    public function __construct(CursoService $cursoService, AuthService $authservice)
    {
        $this -> cursoService = $cursoService;
        $this -> _authService = $authservice;
    }

    public function index()
    {
        // Verificar si hay token JWT para usuario autenticado
        try {
            $token = request()->bearerToken();
            if ($token) {
                $user = JWTAuth::setToken($token)->toUser();
                if ($user) {
                    // Usuario autenticado - incluir información de inscripción
                    $cursos = $this->cursoService->obtenerCursos($user->id_usuario);
                    return response()->json($cursos);
                }
            }
        } catch (\Exception $e) {
            // Si falla la autenticación, continúa sin userId
        }
        
        // Usuario no autenticado - solo cursos básicos
        $cursos = $this->cursoService->obtenerCursos();
        return response()->json($cursos);
    }

    public function show($id)
    {
        $curso = $this -> cursoService -> obtenerCursoPorId($id);
        return response() -> json($curso);
    }

    public function indexMyCourses(Request $request)
    {
        try
        {
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token);
            $courses = $this->cursoService->getMyCourses($user->id_usuario);
            return response()->json($courses, 200);
        }
        catch (JWTException $e)
        {
            return response()->json([
                'error' => 'No autorizado: Token inválido.',
                'message' => $e->getMessage() 
            ], 401);
        }
        catch (\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus cursos.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function enroll(EnrollRequest $request)
    {
        try
        {
            // validaciones por el servicio de auth
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token);

            $validedData = $request->validated(); 
            $idCourse = $validedData['id_curso'];

            $this->cursoService->enRoll($user->id_usuario, $idCourse);
            return response()->json(['message' => 'Inscripción exitosa'], 201);
        }
        catch (JWTException $e) 
        {
            // Error Específico de Autenticación
            return response()->json(['error' => 'No autorizado: ' . $e->getMessage()], 401);
        }
        catch (\Exception $e) 
        {
            // Error Específico de Negocio (ej. "Ya inscrito")
            return response()->json(['error' => $e->getMessage()], 422);
        }
        catch (\Throwable $t) 
        {
            // Cualquier otro error fatal (código 500)
            return response()->json([
                'error' => 'Ocurrió un error fatal en el servidor.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    // Controller Admin
    public function indexCoursesInstructor(Request $req)
    {
        try
        {
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token); 
            if($user->id_rol != 1)
            {
                return response()->json([
                    'error' => 'No eres instructor.', 
                ], 403);
            }
            $courses = $this->cursoService->getInstructorCourses($user->id_usuario);
            return response()->json($courses, 200);

            
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus cursos.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }
    public function storeCourseInstructor(StoreCourseRequest $request)
    {
        try
        {
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token); 
            if($user->id_rol != 1)
            {
                return response()->json([
                    'error' => 'No eres instructor.', 
                ], 403);
            }

            $data = $request->validated(); 
            $newCourse =  $this->cursoService->createCourse($data, $user->id_usuario);

            return response()-> json($newCourse, 201); 
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la creación de tu curso.',
                'message' => $t->getMessage() 
            ], 500);
        }       

    }

    public function updateCourseInstructor(UpdateCourseRequest $req, $idCourse)
    {
        try
        {
            
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token); 
            if($user->id_rol != 1)
            {
                return response()->json([
                    'error' => 'No eres instructor.', 
                ], 403);
            }
    
            $data = $req->validated(); 
            $this->cursoService->updateCourse($idCourse,$data,$user->id_usuario);
            return response()-> json([
                'message' => 'Curso actualizado correctamente',
            ],200);
        }
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la creación de tu curso.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function destroyCoursesInstructor($idCourse)
    {
        try
        {
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token); 
            if($user->id_rol != 1)
            {
                return response()->json([
                    'error' => 'No eres instructor.', 
                ], 403);
            }
            $this->cursoService->removeCourse($idCourse,$user->id_usuario);
             return response()-> json([
                'message' => 'Curso eliminado correctamente',
            ],204);
        }
        catch (JWTException $e) 
        {
            // Error Específico de Autenticación
            return response()->json(['error' => 'No autorizado: ' . $e->getMessage()], 401);
        }
        catch (\Exception $e) 
        {
            // Error Específico de Negocio (ej. "Ya inscrito")
            return response()->json(['error' => $e->getMessage()], 422);
        }
        catch (\Throwable $t) 
        {
            // Cualquier otro error fatal (código 500)
            return response()->json([
                'error' => 'Ocurrió un error fatal en el servidor.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function publishCourse($idCourse)
    {
        try
        {
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token); 
            
            if($user->id_rol != 1)
            {
                return response()->json([
                    'error' => 'No eres instructor.', 
                ], 403);
            }

            $this->cursoService->publishCourse($idCourse, $user->id_usuario);
            
            return response()->json([
                'message' => 'Curso publicado correctamente',
                'success' => true
            ], 200);
        }
        catch (JWTException $e) 
        {
            return response()->json(['error' => 'No autorizado: ' . $e->getMessage()], 401);
        }
        catch (\Exception $e) 
        {
            return response()->json(['error' => $e->getMessage()], 422);
        }
        catch (\Throwable $t) 
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la publicación del curso.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function verCurso($id)
    {
        try {
            // Verificar autenticación JWT
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user || $user->rol !== 'instructor') {
                return redirect('/login')->with('error', 'No autorizado');
            }

            // Buscar el curso usando DB facade
            $curso = DB::table('cursos as c')
                ->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')
                ->select(
                    'c.*',
                    'cat.nombre_categoria as categoria_nombre'
                )
                ->where('c.id_curso', $id)
                ->where('c.instructor_id', $user->id)
                ->first();

            if (!$curso) {
                return redirect('/panel-instructor')->with('error', 'Curso no encontrado');
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

            // Obtener estadísticas
            $totalModulos = $modulos->count();
            $totalLecciones = 0;
            foreach ($modulos as $modulo) {
                $totalLecciones += count($modulo->lecciones);
            }

            $totalInscripciones = DB::table('inscripciones')
                ->where('id_curso', $id)
                ->count();

            return view('ver_curso', compact(
                'curso', 
                'modulos',
                'totalModulos', 
                'totalLecciones', 
                'totalInscripciones'
            ));

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return redirect('/login')->with('error', 'Token expirado');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return redirect('/login')->with('error', 'Token inválido');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return redirect('/login')->with('error', 'Token no proporcionado');
        } catch (\Exception $e) {
            return redirect('/panel-instructor')->with('error', 'Error al cargar el curso');
        }
    }

    public function verCursoEstudiante($id)
    {
        try {
            // Verificar autenticación JWT
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user || $user->rol !== 'estudiante') {
                return redirect('/login')->with('error', 'No autorizado');
            }

            // Verificar que el estudiante esté inscrito en el curso
            $inscripcion = DB::table('inscripciones')
                ->where('id_usuario', $user->id)
                ->where('id_curso', $id)
                ->first();

            if (!$inscripcion) {
                return redirect('/mis-cursos')->with('error', 'No estás inscrito en este curso');
            }

            // Buscar el curso usando DB facade
            $curso = DB::table('cursos as c')
                ->leftJoin('categorias as cat', 'c.id_categoria', '=', 'cat.id_categoria')
                ->leftJoin('usuarios as u', 'c.instructor_id', '=', 'u.id')
                ->select(
                    'c.*',
                    'cat.nombre_categoria as categoria_nombre',
                    'u.nombre as instructor_nombre',
                    'u.apellido as instructor_apellido'
                )
                ->where('c.id_curso', $id)
                ->where('c.estado', 'publicado')
                ->first();

            if (!$curso) {
                return redirect('/mis-cursos')->with('error', 'Curso no encontrado');
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
                    
                // Obtener recursos para cada lección
                foreach ($modulo->lecciones as $leccion) {
                    $leccion->recursos = DB::table('recursos')
                        ->where('id_leccion', $leccion->id_leccion)
                        ->get();
                }
            }

            // Obtener estadísticas
            $totalModulos = $modulos->count();
            $totalLecciones = 0;
            foreach ($modulos as $modulo) {
                $totalLecciones += count($modulo->lecciones);
            }

            // Calcular progreso del estudiante
            $leccionesCompletadas = DB::table('progreso_lecciones as pl')
                ->join('lecciones as l', 'pl.id_leccion', '=', 'l.id_leccion')
                ->join('modulos as m', 'l.id_modulo', '=', 'm.id_modulo')
                ->where('m.id_curso', $id)
                ->where('pl.id_inscripcion', $inscripcion->id_inscripcion)
                ->where('pl.completado', true)
                ->count();

            $progresoCalculado = $totalLecciones > 0 ? ($leccionesCompletadas / $totalLecciones) * 100 : 0;

            return view('ver_curso_estudiante', compact(
                'curso', 
                'modulos',
                'totalModulos', 
                'totalLecciones', 
                'progresoCalculado',
                'leccionesCompletadas',
                'inscripcion'
            ));

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return redirect('/login')->with('error', 'Token expirado');
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return redirect('/login')->with('error', 'Token inválido');
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return redirect('/login')->with('error', 'Token no proporcionado');
        } catch (\Exception $e) {
            return redirect('/mis-cursos')->with('error', 'Error al cargar el curso');
        }
    }
    

}
