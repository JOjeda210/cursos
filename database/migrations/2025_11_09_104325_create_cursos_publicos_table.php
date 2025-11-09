<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cursos_publicos', function(Blueprint $table)
        {
            $table -> id();
            $table -> string('nombre');
            $table -> text('descripcion') -> nullable();
            $table -> string('duracion', 50) -> nullable();
            $table -> string('url') -> nullable();
            $table -> timestamps();
            $table -> booblean('publicado') -> default(true);

            $table -> index('publicado');
            $table -> index('nombre');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cursos_publicos');
    }
};