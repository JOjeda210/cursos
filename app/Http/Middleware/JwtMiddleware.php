<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }
            
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expirado'], 401);
            
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
            
        } catch (JWTException $e) {
            return response()->json(['error' => 'Token no proporcionado'], 401);
        }

        return $next($request);
    }
}