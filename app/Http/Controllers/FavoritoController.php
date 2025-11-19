<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class FavoritoController extends Controller
{
    protected $favoritoService;

    public function __contruct(FavoritoService $favoritoService)
    {
        $this -> favoritoService = $favoritoService;
    }

    public function agregarFavorito(Request $request)
    {
      $validator = Validator::make($request -> all(), [
        'id_curso' => 'required|integer|exists:cursos,id_curso',
      ]);

      if($validator -> fails())
      {
        return response() -> json(['error' => $validator -> errors()], 422);
      }

      try
      {

        $usuarioID = Auth::user() -> id_usuario;
        $cursoID = $request -> input('id_curso');

        $resultado = $this -> favoritoService -> agregar($usuarioID, $cursoID);
        return response() -> json(['message' => $resltado['message']], $resultado['status']);
      }
    }

    public function eliminarFavorito(Request $request)
    {
        $validator = Validator::make($request -> all(), [
            'id_curso' => 'required|integer',
        ]);

        if($validator -> fails())
        {
            return response() -> json(['error' => $validator -> errors()], 422);
        }

        try
        {
            $usuarioID = Auth::user() -> id_usuario;
            $cursoID = $request -> input('id_curso');

            $resultado = $this -> favoritoService -> eliminar($usuarioID, $cursoID);
            return response() -> json(['message' => $resultado['message']], $resultado['status']);
    
        }
    }
}
