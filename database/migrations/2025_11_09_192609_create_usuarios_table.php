<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            create table usuarios (
                id_usuario int primary key auto_increment,
                email varchar(75) unique not null,
                contraseña varchar(75) not null,
                nombre varchar(100) not null,
                apellido varchar(100) not null,
                fecha_registro datetime default current_timestamp,
                id_rol int not null,
                activo boolean default true,
                foreign key (id_rol) references roles(id_rol)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists usuarios");
    }
};
