<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

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

   

}
