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
            create table lecciones (
                id_leccion int primary key auto_increment,
                id_modulo int not null,
                titulo varchar(150) not null,
                contenido text,
                duracion int default 0 comment 'Minutos',
                orden int not null,
                tipo enum('video', 'texto', 'quiz', 'recurso') not null,
                foreign key (id_modulo) references modulos(id_modulo)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists lecciones");
    }
};
