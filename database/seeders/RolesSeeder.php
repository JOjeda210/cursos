<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'nombre_rol' => 'Admin',
                'permisos' => 'Full Access'
            ],
            [
                'nombre_rol' => 'Usuario',
                'permisos' => 'Standard Access'
            ]
        ];

        foreach ($roles as $rol) {
            DB::table('roles')->insert($rol);
        }
    }
}