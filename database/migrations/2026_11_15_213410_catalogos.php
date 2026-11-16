<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Apéndice 1 - Aduanas
        Schema::create('cat_aduanas', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 10)->unique();
            $table->string('denominacion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 2 - Claves de pedimento
        Schema::create('cat_claves_pedimento', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->string('grupo')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 3 - Medios de transporte
        Schema::create('cat_medios_transporte', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 4 - Países
        Schema::create('cat_paises', function (Blueprint $table) {
            $table->id();
            $table->string('clave_saai_fiii', 5)->nullable();
            $table->string('clave_saai_m3', 5)->nullable();
            $table->string('nombre');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 5 - Monedas
        Schema::create('cat_monedas', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('nombre');
            $table->string('pais')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 6 - Recintos fiscalizados
        Schema::create('cat_recintos_fiscalizados', function (Blueprint $table) {
            $table->id();
            $table->string('aduana')->nullable();
            $table->string('clave', 10);
            $table->string('nombre');
            $table->boolean('autorizado_elaboracion')->default(false);
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 7 - (si aplica identificadores especiales, se unifica con 8)
        // Apéndice 8 - Identificadores
        Schema::create('cat_identificadores', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->string('nivel', 5)->nullable(); // G / P
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 9 - Regulaciones y restricciones no arancelarias
        Schema::create('cat_restricciones', function (Blueprint $table) {
            $table->id();
            $table->string('secretaria')->nullable();
            $table->string('clave', 5);
            $table->text('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 10 - Tipos de contenedores
        Schema::create('cat_contenedores', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 11 - Métodos de valoración
        Schema::create('cat_metodos_valoracion', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 12 - Contribuciones
        Schema::create('cat_contribuciones', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->string('abreviatura', 20)->nullable();
            $table->string('nivel', 10)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 13 - Formas de pago
        Schema::create('cat_formas_pago', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 14 - Incoterms
        Schema::create('cat_incoterms', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->string('grupo', 5)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 15 - Destinos
        Schema::create('cat_destinos', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 16 - Regímenes
        Schema::create('cat_regimenes', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 17 - Estructura código de barras (documentación, no se crea tabla de catálogo)
        // Apéndice 18 - Tipos de tasa
        Schema::create('cat_tipos_tasa', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 19 - Sustancias peligrosas
        Schema::create('cat_sustancias_peligrosas', function (Blueprint $table) {
            $table->id();
            $table->string('clave', 5)->unique();
            $table->string('descripcion');
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 20 - Pago electrónico (estructura, no catálogo)
        // Apéndice 21 - Recintos Fiscalizados Estratégicos
        Schema::create('cat_rfe', function (Blueprint $table) {
            $table->id();
            $table->string('aduana')->nullable();
            $table->string('clave_rfe', 10)->nullable();
            $table->string('administrador')->nullable();
            $table->string('clave_operador', 10)->nullable();
            $table->string('operador')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });

        // Apéndice 22 - Características RFID (documentación, no se crea tabla)
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_rfe');
        Schema::dropIfExists('cat_sustancias_peligrosas');
        Schema::dropIfExists('cat_tipos_tasa');
        Schema::dropIfExists('cat_regimenes');
        Schema::dropIfExists('cat_destinos');
        Schema::dropIfExists('cat_incoterms');
        Schema::dropIfExists('cat_formas_pago');
        Schema::dropIfExists('cat_contribuciones');
        Schema::dropIfExists('cat_metodos_valoracion');
        Schema::dropIfExists('cat_contenedores');
        Schema::dropIfExists('cat_restricciones');
        Schema::dropIfExists('cat_identificadores');
        Schema::dropIfExists('cat_recintos_fiscalizados');
        Schema::dropIfExists('cat_monedas');
        Schema::dropIfExists('cat_paises');
        Schema::dropIfExists('cat_medios_transporte');
        Schema::dropIfExists('cat_claves_pedimento');
        Schema::dropIfExists('cat_aduanas');
    }
};
