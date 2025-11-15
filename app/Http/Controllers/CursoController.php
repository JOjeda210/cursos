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

    

}
