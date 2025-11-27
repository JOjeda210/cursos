<?php

namespace App\Http\Requests\Lessons;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLessonRequest extends FormRequest
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
            'titulo' => 'sometimes|required|string|max:150',
            'orden' => 'sometimes|required|integer',
            'tipo' => 'sometimes|required|in:video,texto,quiz,recurso',
            'contenido' => 'nullable|string',
            'duracion' => 'nullable|integer|min:0'
        ];
    }
}
