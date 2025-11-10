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
            create table modulos (
                id_modulo int primary key auto_increment,
                id_curso int not null,
                titulo varchar(150) not null,
                orden int not null,
                foreign key (id_curso) references cursos(id_curso)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists modulos");
    }
};
