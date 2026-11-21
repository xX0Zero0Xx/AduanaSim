<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pedimentos', function (Blueprint $table) {
            // Cabecera oficial
            $table->string('destino_clave', 10)->nullable()->after('tipo_operacion');
            $table->decimal('tipo_cambio', 12, 6)->nullable()->after('destino_clave');
            $table->decimal('peso_bruto', 14, 3)->nullable()->after('tipo_cambio');
            $table->string('seccion_aduanera', 20)->nullable()->after('aduana_clave');

            // Medios de transporte detallados
            $table->string('medio_entrada_clave', 10)->nullable()->after('medio_transporte_clave');
            $table->string('medio_arribo_clave', 10)->nullable()->after('medio_entrada_clave');
            $table->string('medio_salida_clave', 10)->nullable()->after('medio_arribo_clave');

            // Valores
            $table->decimal('valor_dolares', 15, 2)->default(0)->after('valor_aduana');
            $table->decimal('precio_pagado', 15, 2)->default(0)->after('valor_dolares');

            // Importador / exportador ampliado
            $table->string('curp_operador', 20)->nullable()->after('nombre_operador');
            $table->string('domicilio_operador')->nullable()->after('curp_operador');

            // Incrementables
            $table->decimal('val_seguros', 15, 2)->default(0)->after('domicilio_operador');
            $table->decimal('seguros', 15, 2)->default(0)->after('val_seguros');
            $table->decimal('fletes', 15, 2)->default(0)->after('seguros');
            $table->decimal('embalajes', 15, 2)->default(0)->after('fletes');
            $table->decimal('otros_incrementables', 15, 2)->default(0)->after('embalajes');

            // Códigos y bultos
            $table->string('codigo_aceptacion', 40)->nullable()->after('otros_incrementables');
            $table->string('codigo_barras_pedimento', 80)->nullable()->after('codigo_aceptacion');
            $table->string('marcas_bultos')->nullable()->after('codigo_barras_pedimento');
            $table->unsignedInteger('total_bultos')->nullable()->after('marcas_bultos');

            // Proveedor / comprador
            $table->string('proveedor_id_fiscal', 30)->nullable()->after('total_bultos');
            $table->string('proveedor_nombre')->nullable()->after('proveedor_id_fiscal');
            $table->string('proveedor_domicilio')->nullable()->after('proveedor_nombre');
            $table->string('vinculacion', 5)->nullable()->after('proveedor_domicilio');

            // CFDI / documento equivalente (resumen)
            $table->string('cfdi_numero', 50)->nullable()->after('vinculacion');
            $table->date('cfdi_fecha')->nullable()->after('cfdi_numero');
            $table->decimal('cfdi_valor_moneda', 15, 2)->nullable()->after('cfdi_fecha');
            $table->decimal('cfdi_factor_moneda', 12, 6)->nullable()->after('cfdi_valor_moneda');
            $table->decimal('cfdi_valor_dolares', 15, 2)->nullable()->after('cfdi_factor_moneda');

            // Agente aduanal
            $table->string('agente_nombre')->nullable()->after('cfdi_valor_dolares');
            $table->string('agente_rfc', 20)->nullable()->after('agente_nombre');
            $table->string('agente_curp', 20)->nullable()->after('agente_rfc');
            $table->string('agente_patente', 20)->nullable()->after('agente_curp');
        });

        Schema::table('pedimento_partidas', function (Blueprint $table) {
            $table->string('umc', 10)->nullable()->after('unidad');
            $table->decimal('cantidad_umc', 12, 3)->nullable()->after('umc');
            $table->string('umt', 10)->nullable()->after('cantidad_umc');
            $table->decimal('cantidad_umt', 12, 3)->nullable()->after('umt');
            $table->string('metodo_valoracion', 10)->nullable()->after('cantidad_umt');
            $table->string('vinculacion', 5)->nullable()->after('metodo_valoracion');
            $table->string('pais_vendedor_clave', 10)->nullable()->after('pais_origen_clave');
            $table->decimal('precio_unitario', 15, 4)->nullable()->after('valor_aduana');
            $table->decimal('val_adu_usd', 15, 2)->nullable()->after('precio_unitario');
            $table->string('marca')->nullable()->after('val_adu_usd');
            $table->string('modelo')->nullable()->after('marca');
            $table->string('codigo_producto')->nullable()->after('modelo');
            $table->text('observaciones_partida')->nullable()->after('codigo_producto');
        });
    }

    public function down(): void
    {
        Schema::table('pedimento_partidas', function (Blueprint $table) {
            $table->dropColumn([
                'umc', 'cantidad_umc', 'umt', 'cantidad_umt', 'metodo_valoracion', 'vinculacion',
                'pais_vendedor_clave', 'precio_unitario', 'val_adu_usd', 'marca', 'modelo',
                'codigo_producto', 'observaciones_partida',
            ]);
        });

        Schema::table('pedimentos', function (Blueprint $table) {
            $table->dropColumn([
                'destino_clave', 'tipo_cambio', 'peso_bruto', 'seccion_aduanera',
                'medio_entrada_clave', 'medio_arribo_clave', 'medio_salida_clave',
                'valor_dolares', 'precio_pagado',
                'curp_operador', 'domicilio_operador',
                'val_seguros', 'seguros', 'fletes', 'embalajes', 'otros_incrementables',
                'codigo_aceptacion', 'codigo_barras_pedimento', 'marcas_bultos', 'total_bultos',
                'proveedor_id_fiscal', 'proveedor_nombre', 'proveedor_domicilio', 'vinculacion',
                'cfdi_numero', 'cfdi_fecha', 'cfdi_valor_moneda', 'cfdi_factor_moneda', 'cfdi_valor_dolares',
                'agente_nombre', 'agente_rfc', 'agente_curp', 'agente_patente',
            ]);
        });
    }
};
