<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $_authService)
    {
        $this->authService = $_authService;
    }

    public function register(RegisterRequest $request)
    {
        try
        {
            $user = $this->authService->register($request->validated());
            return response()-> json($user, 201); 
        }
        catch (\Exception $e)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante el registro.',
                'message' => $e->getMessage() 
            ], 500);
        }
    }

    public function login(LoginRequest $lRequest)
    {
        try
        {
            $credentials = $lRequest ->validated(); 
            $token = $this->authService->login($credentials['email'], $credentials['password']); 
            return response()->json(['token' => $token], 200);
        }
        catch (\Exception $e)
        {
          return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function logout(Request $request)
    {
        $token = $request->bearerToken();  
        $this->authService->logout($token);  
        return response()->json(['message' => 'Sesión cerrada exitosamente']);
    }


}
