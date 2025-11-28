<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Modules\StoreModuleRequest;
use App\Http\Requests\Modules\UpdateModuleRequest;
use App\Services\ModuleService;
use App\Services\AuthService;
use Tymon\JWTAuth\Exceptions\JWTException;

class ModuleController extends Controller
{
    protected $_moduleService; 
    protected $_authService; 
    public function __construct(ModuleService $moduleService, AuthService $authService)
    {
       $this->_moduleService = $moduleService;
       $this->_authService = $authService;
    }

    public function indexModules($idCourse)
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
            return response()->json($this->_moduleService->getModulesByCourse($idCourse), 200);        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus modulos en este curso.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function storeModule(StoreModuleRequest $request)
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
            $newModule =  $this->_moduleService->createModule($data, $user->id_usuario);

            return response()-> json($newModule, 201); 
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la creación de tu modulo.',
                'message' => $t->getMessage() 
            ], 500);
        }       
    }

    public function updateModule(UpdateModuleRequest $request, $idModule)
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
            $this->_moduleService->updateModule($idModule,$data,$user->id_usuario);
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
                'error' => 'Ocurrió un error interno durante la actualización de tu module.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function destroyModule($idModule)
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
            $this->_moduleService->deleteModule($idModule,$user->id_usuario);
            return response()-> json([
                'message' => 'Modulo eliminado correctamente',
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

}
