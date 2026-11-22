<?php

namespace Database\Seeders;

use App\Models\Pedimento;
use App\Models\PedimentoPartida;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedimentoPrueba extends Seeder
{
    /**
     * Inserta un pedimento de prueba completo asociado al usuario capturista.
     */
    public function run(): void
    {
        $capturista = User::where('email', 'capturista@AduanaSim.local')
            ->orWhere(function ($q) {
                $q->where('rol', 'capturista')->where('name', 'like', '%capturista%');
            })
            ->first();

        if (! $capturista) {
            $this->command?->error('No se encontró el usuario capturista (capturista@AduanaSim.local). Ejecuta primero UsuariosDePrueba.');
            return;
        }

        $folio = 'PED-PRUEBA-001';

        // Evitar duplicados al re-ejecutar
        $existente = Pedimento::where('folio', $folio)->first();
        if ($existente) {
            $existente->partidas()->delete();
            $existente->delete();
            $this->command?->info("Pedimento {$folio} anterior eliminado para recrearlo.");
        }

        DB::transaction(function () use ($capturista, $folio) {
            $pedimento = Pedimento::create([
                'user_id' => $capturista->id,
                'equipo_id' => $capturista->equipo_id ?? null,
                'folio' => $folio,
                'tipo' => 'tradicional',
                'tipo_operacion' => 'importacion',

                // Cabecera / identificación
                'aduana_clave' => '160',          // Manzanillo
                'seccion_aduanera' => '1',
                'clave_pedimento' => 'A1',         // Importación o exportación definitiva
                'regimen_clave' => 'IMD',          // Definitivo de importación
                'destino_clave' => '9',            // Interior del País
                'patente' => '1234',

                'tipo_cambio' => 17.2500,
                'peso_bruto' => 1250.500,

                // Operador / importador
                'rfc_operador' => 'XAXX010101000',
                'nombre_operador' => 'COMERCIALIZADORA DEMO SA DE CV',
                'curp_operador' => null,
                'domicilio_operador' => 'Av. Reforma 100, Col. Centro, CDMX, C.P. 06000',

                // Transporte
                'medio_transporte_clave' => '7',   // Marítimo (si existe en catálogo)
                'medio_entrada_clave' => '7',
                'medio_arribo_clave' => '7',
                'medio_salida_clave' => null,

                // Países / moneda / incoterm
                'pais_origen_clave' => 'CHN',
                'pais_destino_clave' => 'MEX',
                'moneda_clave' => 'USD',
                'incoterm_clave' => 'FOB',

                // Valores
                'valor_comercial' => 25000.00,
                'valor_aduana' => 26800.00,
                'valor_dolares' => 25000.00,
                'precio_pagado' => 25000.00,
                'val_seguros' => 200.00,
                'seguros' => 200.00,
                'fletes' => 1500.00,
                'embalajes' => 100.00,
                'otros_incrementables' => 0.00,

                // Códigos / marcas
                'codigo_aceptacion' => null,
                'codigo_barras_pedimento' => null,
                'marcas_bultos' => 'DEMO / MADE IN CHINA',
                'total_bultos' => 40,

                // Proveedor
                'proveedor_id_fiscal' => 'CN-SUPPLIER-001',
                'proveedor_nombre' => 'SHENZHEN DEMO TRADING CO LTD',
                'proveedor_domicilio' => 'No. 88 Industrial Park, Shenzhen, China',
                'vinculacion' => '0',

                // CFDI (simulado)
                'cfdi_numero' => 'A 12345',
                'cfdi_fecha' => now()->subDays(5)->toDateString(),
                'cfdi_valor_moneda' => 25000.00,
                'cfdi_factor_moneda' => 1.000000,
                'cfdi_valor_dolares' => 25000.00,

                // Agente
                'agente_nombre' => 'AGENTE ADUANAL DEMO',
                'agente_rfc' => 'AAD850101XXX',
                'agente_curp' => null,
                'agente_patente' => '1234',

                'observaciones' => 'Pedimento de prueba generado por PedimentoPruebaSeeder. Solo con fines académicos.',
                'estatus' => 'borrador',
            ]);

            // Partida 1
            PedimentoPartida::create([
                'pedimento_id' => $pedimento->id,
                'secuencia' => 1,
                'fraccion' => '85171201',
                'nico' => '00',
                'descripcion' => 'Teléfonos móviles (celulares) — unidades de demostración',
                'cantidad' => 100,
                'unidad' => 'PZA',
                'umc' => 'PZA',
                'cantidad_umc' => 100,
                'umt' => 'PZA',
                'cantidad_umt' => 100,
                'metodo_valoracion' => '1',
                'vinculacion' => '0',
                'valor_comercial' => 15000.00,
                'valor_aduana' => 16080.00,
                'precio_unitario' => 150.0000,
                'val_adu_usd' => 15000.00,
                'pais_origen_clave' => 'CHN',
                'pais_vendedor_clave' => 'CHN',
                'marca' => 'DEMOTECH',
                'modelo' => 'DT-X100',
                'codigo_producto' => 'SKU-CEL-001',
                'observaciones_partida' => 'Partida de prueba 1',
            ]);

            // Partida 2
            PedimentoPartida::create([
                'pedimento_id' => $pedimento->id,
                'secuencia' => 2,
                'fraccion' => '84713001',
                'nico' => '00',
                'descripcion' => 'Máquinas automáticas para tratamiento o procesamiento de datos, portátiles',
                'cantidad' => 20,
                'unidad' => 'PZA',
                'umc' => 'PZA',
                'cantidad_umc' => 20,
                'umt' => 'PZA',
                'cantidad_umt' => 20,
                'metodo_valoracion' => '1',
                'vinculacion' => '0',
                'valor_comercial' => 10000.00,
                'valor_aduana' => 10720.00,
                'precio_unitario' => 500.0000,
                'val_adu_usd' => 10000.00,
                'pais_origen_clave' => 'CHN',
                'pais_vendedor_clave' => 'CHN',
                'marca' => 'DEMOTECH',
                'modelo' => 'NB-500',
                'codigo_producto' => 'SKU-LAP-002',
                'observaciones_partida' => 'Partida de prueba 2',
            ]);

            $this->command?->info("Pedimento de prueba creado: {$folio} (id {$pedimento->id}) para usuario {$capturista->email}");
        });
    }
}
