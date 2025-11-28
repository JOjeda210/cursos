<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'id_leccion' => 'required|integer|exists:lecciones,id_leccion',
            'titulo' => 'required|string|max:150',
            'tipo' => 'required|in:video,pdf,link,imagen',
            'url' => [
                'nullable', 
                Rule::requiredIf(fn () => in_array($this->tipo, ['video', 'link'])),
                'string',
                'max:255'
            ],

            'file' => [
                'nullable',
                Rule::requiredIf(fn () => in_array($this->tipo, ['pdf', 'imagen'])),
                'file', 
                'max:10240', 
                function ($attribute, $value, $fail) {
                    if ($this->tipo === 'pdf' && $value->getMimeType() !== 'application/pdf') {
                        $fail('El archivo debe ser un PDF válido.');
                    }
                    if ($this->tipo === 'imagen' && !str_starts_with($value->getMimeType(), 'image/')) {
                        $fail('El archivo debe ser una imagen válida (jpg, png, etc).');
                    }
                },
            ],
        ];
    }
}