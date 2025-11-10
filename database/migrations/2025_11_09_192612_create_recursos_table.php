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
            create table recursos (
                id_recurso int primary key auto_increment,
                id_leccion int not null,
                tipo enum('video', 'pdf', 'link', 'imagen') not null,
                url varchar(150) not null,
                titulo varchar(150) not null,
                foreign key (id_leccion) references lecciones(id_leccion)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists recursos");
    }
};
