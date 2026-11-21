<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PedimentoPartida extends Model
{
    protected $fillable = [
        'pedimento_id', 'secuencia', 'fraccion', 'nico', 'descripcion',
        'cantidad', 'unidad', 'umc', 'cantidad_umc', 'umt', 'cantidad_umt',
        'metodo_valoracion', 'vinculacion',
        'valor_comercial', 'valor_aduana', 'precio_unitario', 'val_adu_usd',
        'pais_origen_clave', 'pais_vendedor_clave',
        'marca', 'modelo', 'codigo_producto', 'observaciones_partida',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'cantidad_umc' => 'decimal:3',
            'cantidad_umt' => 'decimal:3',
            'valor_comercial' => 'decimal:2',
            'valor_aduana' => 'decimal:2',
            'precio_unitario' => 'decimal:4',
            'val_adu_usd' => 'decimal:2',
        ];
    }

    public function pedimento(): BelongsTo
    {
        return $this->belongsTo(Pedimento::class);
    }
}
