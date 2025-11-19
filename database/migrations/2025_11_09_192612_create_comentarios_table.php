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
            create table comentarios (
                id_comentario int primary key auto_increment,
                id_usuario int not null,
                id_curso int not null,
                contenido text not null,
                fecha_comentario timestamp default current_timestamp,
                respuesta_a int,
                foreign key (id_usuario) references usuarios(id_usuario),
                foreign key (id_curso) references cursos(id_curso),
                foreign key (respuesta_a) references comentarios(id_comentario)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists comentarios");
    }
};
