<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            create table valoraciones (
                id_valoracion int primary key auto_increment,
                id_curso int not null,
                id_usuario int not null,
                puntuacion int not null comment 'Valoración del 1 al 5',
                comentario text,
                fecha_valoracion datetime default current_timestamp,
                activo boolean default true,
                foreign key (id_curso) references cursos(id_curso),
                foreign key (id_usuario) references usuarios(id_usuario),
                check (puntuacion >= 1 and puntuacion <= 5)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists valoraciones");
    }
};
