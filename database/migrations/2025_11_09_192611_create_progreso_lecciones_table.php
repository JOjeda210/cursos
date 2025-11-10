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
            create table progreso_lecciones (
                id_progreso int primary key auto_increment,
                id_inscripcion int not null,
                id_leccion int not null,
                completado boolean default false,
                fecha_completado datetime,
                foreign key (id_inscripcion) references inscripciones(id_inscripcion),
                foreign key (id_leccion) references lecciones(id_leccion)
                );      
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists progreso_lecciones");
    }
};
