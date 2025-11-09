<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;
use App\Http\Controllers\Controller;

class CursoController extends Controller
{
    protected $cursoService;
    public function __construct(CursoService $cursoService)
    {
        $this -> cursoService = $cursoService;
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
