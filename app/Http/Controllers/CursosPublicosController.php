<?php
namespace App\Http\Controllers;
use App\Services\CursosPublicos;
use Illuminate\Http\Request;

class CursosPublicosController extends Controller
{
    private $service;

    public funtion __construct(CursosPublicos $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $filtros = $request -> only(['categoria', 'titulo', 'limit', 'offset']);
        $cursos = $this -> service -> buscar($filtros);

        return response() -> json($cursos);
    }

    public function show($id)
    {
        try
        {
            $curso = $this -> service -> obtenerCursosid($id);
        }

        catch(\InvalidArgumentException $e) 
        {
            return response() -> json(['error' => 'No existe este curso'], 404);
        }

        if(!$cursos)
        {
            return response() -> json(['error' => 'No existe ese curso'], 404);
        }

        return response() -> json($curso);
    }

    public function listadeTodosloscursos()
    {
        $cursos = $this -> service -> obtenerCursospublicos();
        return response() -> json($cursos);
    }
}