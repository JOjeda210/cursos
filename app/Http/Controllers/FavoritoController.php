<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Services\FavoritoService;

class FavoritoController extends Controller
{
    protected $favoritoService;

    public function __construct(FavoritoService $favoritoService)
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

        $resultado = $this -> favoritoService -> agregarFavorito($usuarioID, $cursoID);
        return response() -> json(['message' => $resultado['message']], $resultado['status']);
      }
      catch(\Exception $e)
      {
        return response() -> json(['error' => 'Error al agregar favorito'], 500);
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

            $resultado = $this -> favoritoService -> eliminarFavorito($usuarioID, $cursoID);
            return response() -> json(['message' => $resultado['message']], $resultado['status']);
    
        }
        catch(\Exception $e)
        {
            return response() -> json(['error' => 'Error al eliminar favorito'], 500);
        }
    }
}
