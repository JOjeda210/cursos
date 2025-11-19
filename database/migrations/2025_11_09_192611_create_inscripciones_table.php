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
            create table inscripciones (
                id_inscripcion int primary key auto_increment,
                id_usuario int not null,
                id_curso int not null,
                fecha_inscripcion datetime default current_timestamp,
                progreso decimal (5,2) default 0.00,
                estado  enum('pendiente', 'en_curso', 'completado', 'cancelado') not null,
                foreign key (id_usuario) references usuarios(id_usuario),
                foreign key (id_curso) references cursos(id_curso)
            );  
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists inscripciones");
    }
};
