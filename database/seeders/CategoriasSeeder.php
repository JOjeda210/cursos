<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre_categoria' => 'Tecnología',
                'descripcion' => 'Cursos relacionados con programación, desarrollo de software, inteligencia artificial, y tecnologías emergentes'
            ],
            [
                'nombre_categoria' => 'Diseño',
                'descripcion' => 'Cursos de diseño gráfico, UI/UX, diseño web, ilustración y arte digital'
            ],
            [
                'nombre_categoria' => 'Marketing',
                'descripcion' => 'Marketing digital, redes sociales, SEO, publicidad online y estrategias de negocio'
            ],
            [
                'nombre_categoria' => 'Negocios',
                'descripcion' => 'Administración, emprendimiento, finanzas, liderazgo y desarrollo empresarial'
            ],
            [
                'nombre_categoria' => 'Idiomas',
                'descripcion' => 'Aprendizaje de idiomas extranjeros, comunicación intercultural y traducción'
            ],
            [
                'nombre_categoria' => 'Salud y Bienestar',
                'descripcion' => 'Fitness, nutrición, mindfulness, yoga y desarrollo personal'
            ]
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert($categoria);
        }
    }
}