<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        Schema::create('equipo_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('rol_en_equipo')->default('miembro'); // lider | miembro
            $table->timestamps();

            $table->unique(['equipo_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipo_user');
        Schema::dropIfExists('equipos');
    }
};
