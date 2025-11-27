<?php

namespace App\Http\Requests\Lessons;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id_modulo' => 'required|integer|exists:modulos,id_modulo',

            // Datos obligatorios
            'titulo' => 'required|string|max:150',
            'orden' => 'required|integer',

            // EL ENUM Solo permite estos 4 valores exactos
            'tipo' => 'required|in:video,texto,quiz,recurso',

            // Campos Opcionales (Nullables)
            'contenido' => 'nullable|string',
            'duracion' => 'nullable|integer|min:0',
        ];
    }
}
