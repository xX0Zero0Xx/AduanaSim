<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoveMercancia extends Model
{
    protected $fillable = [
        'cove_id',
        'secuencia',
        'descripcion',
        'cantidad',
        'unidad',
        'valor',
        'fraccion',
    ];

    protected function casts(): array
    {
        return [
            'cantidad' => 'decimal:3',
            'valor' => 'decimal:2',
        ];
    }

    public function cove(): BelongsTo
    {
        return $this->belongsTo(Cove::class);
    }
}
