<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\ResourceService;
use App\Services\AuthService;
use App\Http\Requests\Resources\StoreResourceRequest; // Asegurate de tener este creado (el que te pasé antes)
use App\Http\Requests\Resources\UpdateResourceRequest;

class ResourceController extends Controller
{
    protected $_resourceService;
    protected $_authService;

    public function __construct(ResourceService $resourceService, AuthService $authService)
    {
        $this->_resourceService = $resourceService;
        $this->_authService = $authService;
    }

    public function indexResource($idLesson)
    {
  
        $token = JWTAuth::getToken();
        $user = $this->_authService->getUserFromToken($token);
        
        if ($user->id_rol != 1) {
            return response()->json(['error' => 'No eres instructor.'], 403);
        }

        $resources = $this->_resourceService->getResourcesByLesson($idLesson);
        return response()->json($resources, 200);
    }

    public function storeResource(StoreResourceRequest $request)
    {
        $token = JWTAuth::getToken();
        $user = $this->_authService->getUserFromToken($token);

        if ($user->id_rol != 1) {
            return response()->json(['error' => 'No eres instructor.'], 403);
        }

        try {
            // Laravel automáticamente incluye el objeto 'file' dentro de validated() si existe
            $data = $request->validated();
            $resource = $this->_resourceService->createResource($data, $user->id_usuario);
            return response()->json($resource, 201);
        } catch (\Throwable $t) {
            return response()->json([
                'error' => 'Error al crear recurso',
                'message' => $t->getMessage()
            ], 500);
        }
    }

    public function updateResource(UpdateResourceRequest $request, $idResource)
    {
        $token = JWTAuth::getToken();
        $user = $this->_authService->getUserFromToken($token);

        if ($user->id_rol != 1) {
            return response()->json(['error' => 'No eres instructor.'], 403);
        }

        try {
            $data = $request->validated();
            $this->_resourceService->updateResource($idResource, $data, $user->id_usuario);
            return response()->json(['message' => 'Recurso actualizado correctamente'], 200);
        } catch (\Throwable $t) {
            return response()->json([
                'error' => 'Error al actualizar recurso',
                'message' => $t->getMessage()
            ], 500);
        }
    }

    public function destroyResource($idResource)
    {
        $token = JWTAuth::getToken();
        $user = $this->_authService->getUserFromToken($token);

        if ($user->id_rol != 1) {
            return response()->json(['error' => 'No eres instructor.'], 403);
        }

        try {
            $this->_resourceService->deleteResource($idResource, $user->id_usuario);
            return response()->json(['message' => 'Recurso eliminado'], 200);
        } catch (\Throwable $t) {
            return response()->json([
                'error' => 'Error al eliminar recurso',
                'message' => $t->getMessage()
            ], 500);
        }
    }
}