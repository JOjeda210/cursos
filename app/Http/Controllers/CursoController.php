<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CursoService;
use App\Services\AuthService;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Courses\EnrollRequest;
use App\Http\Requests\Courses\UpdateCourseRequest;
use App\Http\Requests\Courses\StoreCourseRequest;
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

    public function enroll(EnrollRequest $request)
    {
        try
        {
            // validaciones por el servicio de auth
            $token = JWTAuth::getToken(); 
            $user = $this->_authService->getUserFromToken($token);

            $validedData = $request->validated(); 
            $idCourse = $validedData['id_curso'];

            $this->cursoService->enRoll($user->id_usuario, $idCourse);
            return response()->json(['message' => 'Inscripción exitosa'], 201);
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

    // Controller Admin
    public function indexInstructor(Request $req)
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
            $courses = $this->cursoService->getInstructorCourses($user->id_usuario);
            return response()->json($courses, 200);

            
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el obtenido de tus cursos.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }
    public function storeInstructor(StoreCourseRequest $request)
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
            $newCourse =  $this->cursoService->createCourse($data, $user->id_usuario);

            return response()-> json($newCourse, 201); 
        }
        catch(\Throwable $t)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la creación de tu curso.',
                'message' => $t->getMessage() 
            ], 500);
        }       

    }

    public function updateCourse(UpdateCourseRequest $req, $idCourse)
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
    
            $data = $req->validated(); 
            $this->cursoService->updateCourse($idCourse,$data,$user->id_usuario);
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
                'error' => 'Ocurrió un error interno durante la creación de tu curso.',
                'message' => $t->getMessage() 
            ], 500);
        }
    }

    public function destroy($idCourse)
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
            $this->cursoService->removeCourse($idCourse,$user->id_usuario);
             return response()-> json([
                'message' => 'Curso eliminado correctamente',
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
