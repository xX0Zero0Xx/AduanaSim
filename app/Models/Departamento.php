<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departamento extends Model
{
    protected $fillable = [
        'clave',
        'nombre',
        'descripcion',
        'activo',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function capturistas(): HasMany
    {
        return $this->hasMany(User::class)->where('rol', 'capturista');
    }

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function etiqueta(): string
    {
        return "{$this->clave} — {$this->nombre}";
    }
}
