<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'precio' => 'numeric|min:0', // Validar si el precio es 0.00 al publicar = curso gratuito
            'imagen_portada' => 'image|mimes:jpg,png,svg|max:2048', 
            'id_categoria' => 'required|exists:categorias,id_categoria', 
        ];
    }
}
