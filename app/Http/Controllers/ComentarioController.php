<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ComentarioService;
use Tymon\JWTAuth\Facades\JWTAuth;

class ComentarioController extends Controller
{
    protected $comentarioService;

    public function __construct(ComentarioService $comentarioService)
    {
        $this->comentarioService = $comentarioService;
    }

    public function agregarComentario(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_curso' => 'required|integer',
            'contenido' => 'required|string|max:1000',
        ]);

        if($validator->fails())
        {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            // Obtener usuario desde el token JWT
            $user = JWTAuth::parseToken()->authenticate();
            $usuarioID = $user->id_usuario;
            
            $cursoID = $request->input('id_curso');
            $contenido = $request->input('contenido');

            $resultado = $this->comentarioService->agregarComentario($usuarioID, $cursoID, $contenido);
            return response()->json($resultado, $resultado['status']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'No autorizado: ' . $e->getMessage()], 401);
        }
    }

    public function eliminarComentario(Request $request, $id_comentario)
    {
        try {
            // Obtener usuario desde el token JWT
            $user = JWTAuth::parseToken()->authenticate();
            $usuarioID = $user->id_usuario;

            $resultado = $this->comentarioService->eliminarComentario($usuarioID, $id_comentario);
            
            return response()->json($resultado, $resultado['status']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'No autorizado: ' . $e->getMessage()], 401);
        }
    }
}