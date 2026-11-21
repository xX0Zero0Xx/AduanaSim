<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cove extends Model
{
    protected $fillable = [
        'user_id',
        'equipo_id',
        'pedimento_id',
        'folio',
        'emisor_rfc',
        'emisor_nombre',
        'destinatario_rfc',
        'destinatario_nombre',
        'moneda_clave',
        'valor_total',
        'observaciones',
        'observaciones_revision',
        'estatus',
        'enviado_at',
        'validado_at',
        'revisado_por',
    ];

    protected function casts(): array
    {
        return [
            'valor_total' => 'decimal:2',
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

    public function pedimento(): BelongsTo
    {
        return $this->belongsTo(Pedimento::class);
    }

    public function revisor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }

    public function facturas(): HasMany
    {
        return $this->hasMany(CoveFactura::class);
    }

    public function mercancias(): HasMany
    {
        return $this->hasMany(CoveMercancia::class)->orderBy('secuencia');
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

    public static function generarFolio(): string
    {
        return 'CV-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }
}
