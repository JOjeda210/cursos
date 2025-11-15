<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\EnrollRequest;
use Tymon\JWTAuth\Exceptions\JWTException;

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
        $cursos = $this -> cursoService -> obtenerCursos();
        return response() -> json($cursos);
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
        catch (\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus cursos.',
                'message' => $t->getMessage() 
            ], 401);
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

}
