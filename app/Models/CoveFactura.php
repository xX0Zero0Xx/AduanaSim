<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoveFactura extends Model
{
    protected $fillable = [
        'cove_id',
        'numero_factura',
        'fecha_factura',
        'valor',
        'moneda_clave',
    ];

    protected function casts(): array
    {
        return [
            'fecha_factura' => 'date',
            'valor' => 'decimal:2',
        ];
    }

    public function cove(): BelongsTo
    {
        return $this->belongsTo(Cove::class);
    }
}
