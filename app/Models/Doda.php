<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doda extends Model
{
    protected $fillable = [
        'user_id',
        'equipo_id',
        'folio',
        'aduana_clave',
        'patente',
        'numero_operacion',
        'fecha_operacion',
        'medio_transporte_clave',
        'placa_o_identificacion',
        'observaciones',
        'observaciones_revision',
        'cadena_qr',
        'codigo_barras',
        'estatus',
        'enviado_at',
        'validado_at',
        'revisado_por',
    ];

    protected function casts(): array
    {
        return [
            'fecha_operacion' => 'date',
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

    public function pedimentos(): BelongsToMany
    {
        return $this->belongsToMany(Pedimento::class, 'doda_pedimento')->withTimestamps();
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
        return 'DO-' . now()->format('ymd') . '-' . strtoupper(substr(uniqid(), -5));
    }

    public function regenerarCadenas(): void
    {
        $payload = implode('|', [
            'ADUANASIM',
            $this->folio,
            $this->aduana_clave ?? '',
            $this->patente ?? '',
            $this->numero_operacion ?? '',
            optional($this->fecha_operacion)->format('Y-m-d') ?? '',
            $this->user_id,
        ]);

        $this->cadena_qr = $payload;
        $this->codigo_barras = preg_replace('/[^A-Z0-9]/', '', strtoupper($this->folio . ($this->patente ?? '')));
        $this->save();
    }
}
