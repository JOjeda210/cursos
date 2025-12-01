<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WebJwtMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Para rutas web, la validación del token se hará en JavaScript
        // Este middleware solo sirve para marcar las rutas que necesitan autenticación
        // La vista se cargará y el JS verificará el token
        return $next($request);
    }
}