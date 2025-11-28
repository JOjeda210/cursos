<?php

namespace App\Http\Requests\Resources;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateResourceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => 'sometimes|string|max:150',
            'tipo'   => 'sometimes|in:video,pdf,link,imagen',
            
            'url' => [
                'nullable',
                'string',
                'max:255'
            ],

            'file' => [
                'nullable',
                'file',
                'max:10240',
            ],
        ];
    }
}