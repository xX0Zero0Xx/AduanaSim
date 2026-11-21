<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedimento extends Model
{
    protected $fillable = [
        'user_id', 'equipo_id', 'folio', 'tipo', 'tipo_operacion',
        'destino_clave', 'tipo_cambio', 'peso_bruto',
        'aduana_clave', 'seccion_aduanera', 'clave_pedimento', 'regimen_clave', 'patente',
        'rfc_operador', 'nombre_operador', 'curp_operador', 'domicilio_operador',
        'medio_transporte_clave', 'medio_entrada_clave', 'medio_arribo_clave', 'medio_salida_clave',
        'pais_origen_clave', 'pais_destino_clave', 'moneda_clave', 'incoterm_clave',
        'valor_comercial', 'valor_aduana', 'valor_dolares', 'precio_pagado',
        'val_seguros', 'seguros', 'fletes', 'embalajes', 'otros_incrementables',
        'codigo_aceptacion', 'codigo_barras_pedimento', 'marcas_bultos', 'total_bultos',
        'proveedor_id_fiscal', 'proveedor_nombre', 'proveedor_domicilio', 'vinculacion',
        'cfdi_numero', 'cfdi_fecha', 'cfdi_valor_moneda', 'cfdi_factor_moneda', 'cfdi_valor_dolares',
        'agente_nombre', 'agente_rfc', 'agente_curp', 'agente_patente',
        'observaciones', 'observaciones_revision',
        'estatus', 'enviado_at', 'validado_at', 'revisado_por',
    ];

    protected function casts(): array
    {
        return [
            'tipo_cambio' => 'decimal:6',
            'peso_bruto' => 'decimal:3',
            'valor_comercial' => 'decimal:2',
            'valor_aduana' => 'decimal:2',
            'valor_dolares' => 'decimal:2',
            'precio_pagado' => 'decimal:2',
            'val_seguros' => 'decimal:2',
            'seguros' => 'decimal:2',
            'fletes' => 'decimal:2',
            'embalajes' => 'decimal:2',
            'otros_incrementables' => 'decimal:2',
            'cfdi_fecha' => 'date',
            'cfdi_valor_moneda' => 'decimal:2',
            'cfdi_factor_moneda' => 'decimal:6',
            'cfdi_valor_dolares' => 'decimal:2',
            'enviado_at' => 'datetime',
            'validado_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function equipo(): BelongsTo
    {
        return $this->belongsTo(Equipo::class);
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    public function partidas(): HasMany
    {
        return $this->hasMany(PedimentoPartida::class)->orderBy('secuencia');
    }

    public function coves(): HasMany
    {
        return $this->hasMany(Cove::class);
    }

    public function dodas(): BelongsToMany
    {
        return $this->belongsToMany(Doda::class, 'doda_pedimento')->withTimestamps();
    }

    public function scopeVisiblesPara(Builder $query, User $user): Builder
    {
        if ($user->isAdmin() || $user->isAgente()) {
            return $query;
        }

        $equipoIds = $user->equipos()->pluck('equipos.id');

        return $query->where(function (Builder $q) use ($user, $equipoIds) {
            $q->where('user_id', $user->id);
            if ($equipoIds->isNotEmpty()) {
                $q->orWhereIn('equipo_id', $equipoIds);
            }
        });
    }

    public function puedeEditarse(): bool
    {
        return in_array($this->estatus, ['borrador', 'devuelto'], true);
    }

    public function puedeEnviarse(): bool
    {
        return in_array($this->estatus, ['borrador', 'devuelto'], true);
    }

    /** PDF disponible cuando ya no es solo captura inicial (enviado o validado) o siempre para práctica */
    public function puedeVerPdf(): bool
    {
        return in_array($this->estatus, ['enviado', 'validado', 'devuelto', 'borrador'], true);
    }

    public function etiquetaEstatus(): string
    {
        return match ($this->estatus) {
            'borrador' => 'Borrador',
            'enviado' => 'En validación',
            'validado' => 'Validado',
            'devuelto' => 'Devuelto',
            default => ucfirst($this->estatus),
        };
    }

    public static function generarFolio(string $tipo = 'tradicional'): string
    {
        $prefijo = $tipo === 'simplificado' ? 'PS' : 'PT';

        return $prefijo . '-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }

    /** Datos útiles para autollenar COVE / DODA */
    public function toAutofillPayload(): array
    {
        return [
            'id' => $this->id,
            'folio' => $this->folio,
            'tipo' => $this->tipo,
            'tipo_operacion' => $this->tipo_operacion,
            'aduana_clave' => $this->aduana_clave,
            'patente' => $this->patente ?: $this->agente_patente,
            'rfc_operador' => $this->rfc_operador,
            'nombre_operador' => $this->nombre_operador,
            'domicilio_operador' => $this->domicilio_operador,
            'moneda_clave' => $this->moneda_clave,
            'incoterm_clave' => $this->incoterm_clave,
            'valor_comercial' => (float) $this->valor_comercial,
            'valor_aduana' => (float) $this->valor_aduana,
            'valor_dolares' => (float) $this->valor_dolares,
            'medio_transporte_clave' => $this->medio_transporte_clave,
            'pais_origen_clave' => $this->pais_origen_clave,
            'pais_destino_clave' => $this->pais_destino_clave,
            'proveedor_id_fiscal' => $this->proveedor_id_fiscal,
            'proveedor_nombre' => $this->proveedor_nombre,
            'proveedor_domicilio' => $this->proveedor_domicilio,
            'cfdi_numero' => $this->cfdi_numero,
            'cfdi_fecha' => optional($this->cfdi_fecha)->format('Y-m-d'),
            'partidas' => $this->partidas->map(fn ($p) => [
                'fraccion' => $p->fraccion,
                'descripcion' => $p->descripcion,
                'cantidad' => (float) $p->cantidad,
                'unidad' => $p->unidad,
                'valor_comercial' => (float) $p->valor_comercial,
                'valor_aduana' => (float) $p->valor_aduana,
                'pais_origen_clave' => $p->pais_origen_clave,
            ])->values()->all(),
        ];
    }
}
