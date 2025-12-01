<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebJwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Para rutas web, simplemente retornamos la vista
        // La validación del token se hará en el frontend con JavaScript
        return $next($request);
    }
}