<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Storage\StoreCursoRequest;
use Illuminate\Support\Facades\DB;
use App\Services\ImageUploadService;

class CursoCreateController extends Controller
{
    protected $imageUploadService;

    public function __construct(ImageUploadService $_imageUploadService) 
    {

        $this->imageUploadService = $_imageUploadService;
    }



    public function store(StoreCursoRequest $request)
    {
        try
        {
           $file = $request->File('imagen_portada');
           $urlImage = $this->imageUploadService->handleUpload($file);
            // get the elements in request for insert in DB
            $titulo = $request->titulo;
            $descripcion = $request->descripcion;
            $precio = $request->precio;
            // Concepto de la consulta segura
            $sql = "INSERT INTO cursos (titulo, descripcion, imagen_portada, precio, id_instructor, id_categoria, estado) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";

            DB::insert($sql, [
                $titulo, 
                $descripcion, 
                $urlImage, 
                $precio,
                $request->id_instructor, 
                $request->id_categoria,  
                'borrador' // Un valor por defecto, ya que es 'not null'
            ]);
                            
            return response()->json([
                'message' => 'Curso creado con éxito',
                'ruta_imagen' => $urlImage 
            ], 201); // 201 = Created

        }
        catch (\Exception $e)
        {
            return response()->json([
                'error' => 'Ocurrió un error interno durante la subida de la imagen.',
                'message' => $e->getMessage() 
            ], 500);
        }
    }
}
