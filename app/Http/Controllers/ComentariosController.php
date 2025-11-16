<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComentariosController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'correo' => 'required|email',
            'comentario' => 'required|string',
            'rating' => 'required|in:1,2,3,4,5',
        ]);

        return back()->with('success', 'Comentario guardado');
    }
}
