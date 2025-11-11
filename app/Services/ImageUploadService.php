<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    public function handleUpload($UploadedFile)
    {
        $urlImage = Storage::disk('public')->put('cursos',$UploadedFile);
        return $urlImage; 
    }
}
