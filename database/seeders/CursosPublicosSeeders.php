<?php
namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

class CursosPublicosSeeders extends Seeder
{
    public function run(): void
    {
        $cursos = [
            [
                'nombre' => '#',
                'descripcion' => '#',
                'duracion' => '#',
                'url' => '#',
            ],
            [
                'nombre' => '#',
                'descripcion' => '#',
                'duracion' => '#',
                'url' => '#',
            ],
            [
                'nombre' => '#',
                'descripcion' => '#',
                'duracion' => '#',
                'url' => '#',
            ]
        ];

        foreach ($cursos as $curso) 
        {
            DB::table('cursos_publicos') -> insert(
            [
                'nombre' => $curso['nombre'],
                'descripcion' => $curso['descripcion'],
                'duracion' => $curso['duracion'],
                'url' => $curso['url'],
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        }
    }
}