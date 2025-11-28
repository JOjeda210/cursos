<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
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
            'titulo' => 'required|string|max:150',
            'descripcion' => 'required|string',
            'precio' => 'numeric|min:0',
            'id_categoria' => 'required|exists:categorias,id_categoria',
            'imagen_portada' => 'nullable|image|mimes:jpg,png,svg|max:2048',
            'estado' => 'required|in:borrador,publicado,oculto',
        ];
    }
}
