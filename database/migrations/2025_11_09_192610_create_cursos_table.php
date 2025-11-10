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
            create table cursos (
                id_curso int primary key auto_increment,
                titulo varchar(150) not null,
                descripcion text,
                imagen_portada varchar(255),
                precio decimal(10,2) default 0.00 not null,
                id_instructor int not null,
                id_categoria int not null,
                fecha_creacion datetime default current_timestamp,
                estado enum('borrador', 'publicado', 'oculto', 'eliminado') not null,
                foreign key (id_instructor) references usuarios(id_usuario),
                foreign key (id_categoria) references categorias(id_categoria)
            );
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("drop table if exists cursos");
    }
};
