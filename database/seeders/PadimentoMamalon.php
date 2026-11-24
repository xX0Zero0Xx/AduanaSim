<?php

namespace Database\Seeders;

use App\Models\Pedimento;
use App\Models\PedimentoPartida;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PadimentoMamalon extends Seeder
{
    /**
     * Inserta el mismo pedimento (y sus partidas) en cada usuario, con folio distinto.
     */
    public function run(): void
    {
        // Cambia a User::where('rol', 'capturista')->get() si solo quieres capturistas
        $usuarios = User::orderBy('id')->get();

        if ($usuarios->isEmpty()) {
            $this->command?->error('No hay usuarios en la base de datos.');
            return;
        }

        foreach ($usuarios as $usuario) {
            $prefijo = strtoupper(Str::before($usuario->email, '@'));
            $prefijo = preg_replace('/[^A-Z0-9]/', '', $prefijo) ?: 'USR';
            $folio = "PED-{$prefijo}-{$usuario->id}";

            $existente = Pedimento::where('folio', $folio)->first();
            if ($existente) {
                $existente->partidas()->delete();
                $existente->delete();
            }

            $equipoId = method_exists($usuario, 'equipos')
                ? ($usuario->equipos()->first()?->id ?? $usuario->equipo_id ?? null)
                : ($usuario->equipo_id ?? null);

            DB::transaction(function () use ($usuario, $equipoId, $folio) {
                $pedimento = Pedimento::create([
                    'user_id' => $usuario->id,
                    'equipo_id' => $equipoId,
                    'folio' => $folio,
                    'tipo' => 'tradicional',
                    'tipo_operacion' => 'importacion',
                    'aduana_clave' => '160',
                    'seccion_aduanera' => '1',
                    'clave_pedimento' => 'A1',
                    'regimen_clave' => 'IMD',
                    'destino_clave' => '9',
                    'patente' => '1234',
                    'tipo_cambio' => 17.2500,
                    'peso_bruto' => 1250.500,
                    'rfc_operador' => 'XAXX010101000',
                    'nombre_operador' => 'COMERCIALIZADORA DEMO SA DE CV',
                    'curp_operador' => null,
                    'domicilio_operador' => 'Av. Reforma 100, Col. Centro, CDMX, C.P. 06000',
                    'medio_transporte_clave' => '7',
                    'medio_entrada_clave' => '7',
                    'medio_arribo_clave' => '7',
                    'medio_salida_clave' => null,
                    'pais_origen_clave' => 'CHN',
                    'pais_destino_clave' => 'MEX',
                    'moneda_clave' => 'USD',
                    'incoterm_clave' => 'FOB',
                    'valor_comercial' => 25000.00,
                    'valor_aduana' => 26800.00,
                    'valor_dolares' => 25000.00,
                    'precio_pagado' => 25000.00,
                    'val_seguros' => 200.00,
                    'seguros' => 200.00,
                    'fletes' => 1500.00,
                    'embalajes' => 100.00,
                    'otros_incrementables' => 0.00,
                    'codigo_aceptacion' => null,
                    'codigo_barras_pedimento' => null,
                    'marcas_bultos' => 'DEMO / MADE IN CHINA',
                    'total_bultos' => 40,
                    'proveedor_id_fiscal' => 'CN-SUPPLIER-001',
                    'proveedor_nombre' => 'SHENZHEN DEMO TRADING CO LTD',
                    'proveedor_domicilio' => 'No. 88 Industrial Park, Shenzhen, China',
                    'vinculacion' => '0',
                    'cfdi_numero' => 'A 12345',
                    'cfdi_fecha' => now()->subDays(5)->toDateString(),
                    'cfdi_valor_moneda' => 25000.00,
                    'cfdi_factor_moneda' => 1.000000,
                    'cfdi_valor_dolares' => 25000.00,
                    'agente_nombre' => 'AGENTE ADUANAL DEMO',
                    'agente_rfc' => 'AAD850101XXX',
                    'agente_curp' => null,
                    'agente_patente' => '1234',
                    'observaciones' => 'Pedimento de prueba generado por MismoPedimentoPorUsuarioSeeder.',
                    'estatus' => 'borrador',
                ]);

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
            });
        }

        $this->command?->info("Pedimento insertado en {$usuarios->count()} usuarios con folios únicos.");
    }
}
