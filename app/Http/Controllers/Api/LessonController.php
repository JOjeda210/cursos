<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Lessons\StoreLessonRequest;
use App\Http\Requests\Modules\UpdateModuleRequest;
use App\Services\LessonService;
use App\Services\AuthService;
use Tymon\JWTAuth\Exceptions\JWTException;

class LessonController extends Controller
{
    protected $_authService; 
    protected $_lessonService;
    public function __construct(LessonService $lService, AuthService $authService ) 
    {
        $this->_lessonService = $lService;
        $this->_authService = $authService;
    }

    public function storeLesson(StoreLessonRequest $request)
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
        try
        {
           $newLesson =  $this->_lessonService->createLesson($data, $user->id_usuario);
            return response()-> json($newLesson, 201); 

        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la creación de tu modulo.',
                'message' => $t->getMessage() 
            ], 500);
        }       
    }


    public function indexLessons($idModule)
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
            return response()->json($this->_lessonService->getLessonsByModule($idModule), 200);        
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus modulos en este curso.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    
}
