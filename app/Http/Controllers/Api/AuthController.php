<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
