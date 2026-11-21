<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ─── PEDIMENTOS ───────────────────────────────────────────────
        Schema::create('pedimentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();

            $table->string('folio', 30)->unique();
            $table->enum('tipo', ['tradicional', 'simplificado'])->default('tradicional');
            $table->enum('tipo_operacion', ['importacion', 'exportacion'])->default('importacion');

            $table->string('aduana_clave', 10)->nullable();
            $table->string('clave_pedimento', 10)->nullable();
            $table->string('regimen_clave', 10)->nullable();
            $table->string('patente', 20)->nullable();

            $table->string('rfc_operador', 20)->nullable();
            $table->string('nombre_operador')->nullable();
            $table->string('medio_transporte_clave', 10)->nullable();
            $table->string('pais_origen_clave', 10)->nullable();
            $table->string('pais_destino_clave', 10)->nullable();
            $table->string('moneda_clave', 10)->nullable();
            $table->string('incoterm_clave', 10)->nullable();

            $table->decimal('valor_comercial', 15, 2)->default(0);
            $table->decimal('valor_aduana', 15, 2)->default(0);

            $table->text('observaciones')->nullable();
            $table->text('observaciones_revision')->nullable();

            $table->enum('estatus', ['borrador', 'enviado', 'validado', 'devuelto'])->default('borrador');
            $table->timestamp('enviado_at')->nullable();
            $table->timestamp('validado_at')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index(['user_id', 'estatus']);
            $table->index('folio');
        });

        Schema::create('pedimento_partidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedimento_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('secuencia')->default(1);
            $table->string('fraccion', 15)->nullable();
            $table->string('nico', 10)->nullable();
            $table->string('descripcion')->nullable();
            $table->decimal('cantidad', 12, 3)->default(0);
            $table->string('unidad', 20)->nullable();
            $table->decimal('valor_comercial', 15, 2)->default(0);
            $table->decimal('valor_aduana', 15, 2)->default(0);
            $table->string('pais_origen_clave', 10)->nullable();
            $table->timestamps();
        });

        // ─── COVE ─────────────────────────────────────────────────────
        Schema::create('coves', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();
            $table->foreignId('pedimento_id')->nullable()->constrained('pedimentos')->nullOnDelete();

            $table->string('folio', 30)->unique();
            $table->string('emisor_rfc', 20)->nullable();
            $table->string('emisor_nombre')->nullable();
            $table->string('destinatario_rfc', 20)->nullable();
            $table->string('destinatario_nombre')->nullable();
            $table->string('moneda_clave', 10)->nullable();
            $table->decimal('valor_total', 15, 2)->default(0);
            $table->text('observaciones')->nullable();
            $table->text('observaciones_revision')->nullable();

            $table->enum('estatus', ['borrador', 'enviado', 'validado', 'devuelto'])->default('borrador');
            $table->timestamp('enviado_at')->nullable();
            $table->timestamp('validado_at')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->index(['user_id', 'estatus']);
        });

        Schema::create('cove_facturas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cove_id')->constrained()->cascadeOnDelete();
            $table->string('numero_factura', 50)->nullable();
            $table->date('fecha_factura')->nullable();
            $table->decimal('valor', 15, 2)->default(0);
            $table->string('moneda_clave', 10)->nullable();
            $table->timestamps();
        });

        Schema::create('cove_mercancias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cove_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('secuencia')->default(1);
            $table->string('descripcion')->nullable();
            $table->decimal('cantidad', 12, 3)->default(0);
            $table->string('unidad', 20)->nullable();
            $table->decimal('valor', 15, 2)->default(0);
            $table->string('fraccion', 15)->nullable();
            $table->timestamps();
        });

        // ─── DODA ─────────────────────────────────────────────────────
        Schema::create('dodas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('equipo_id')->nullable()->constrained('equipos')->nullOnDelete();

            $table->string('folio', 30)->unique();
            $table->string('aduana_clave', 10)->nullable();
            $table->string('patente', 20)->nullable();
            $table->string('numero_operacion', 40)->nullable();
            $table->date('fecha_operacion')->nullable();
            $table->string('medio_transporte_clave', 10)->nullable();
            $table->string('placa_o_identificacion')->nullable();
            $table->text('observaciones')->nullable();
            $table->text('observaciones_revision')->nullable();

            // Cadena simulada para QR / código de barras académico
            $table->text('cadena_qr')->nullable();
            $table->string('codigo_barras', 80)->nullable();

            $table->enum('estatus', ['borrador', 'enviado', 'validado', 'devuelto'])->default('borrador');
            $table->timestamp('enviado_at')->nullable();
            $table->timestamp('validado_at')->nullable();
            $table->foreignId('revisado_por')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->index(['user_id', 'estatus']);
        });

        Schema::create('doda_pedimento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doda_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pedimento_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['doda_id', 'pedimento_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doda_pedimento');
        Schema::dropIfExists('dodas');
        Schema::dropIfExists('cove_mercancias');
        Schema::dropIfExists('cove_facturas');
        Schema::dropIfExists('coves');
        Schema::dropIfExists('pedimento_partidas');
        Schema::dropIfExists('pedimentos');
    }
};
