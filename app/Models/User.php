<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'rol', 'activo', 'departamento_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'activo' => 'boolean',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->rol === 'admin';
    }

    public function isAgente(): bool
    {
        return $this->rol === 'agente';
    }

    public function isCapturista(): bool
    {
        return $this->rol === 'capturista';
    }

    public function hasRole(string|array $roles): bool
    {
        $roles = (array) $roles;

        return in_array($this->rol, $roles, true);
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function equipos()
    {
        return $this->belongsToMany(Equipo::class)
            ->withPivot('rol_en_equipo')
            ->withTimestamps();
    }

    public function pedimentos()
    {
        return $this->hasMany(Pedimento::class);
    }

    public function coves()
    {
        return $this->hasMany(Cove::class);
    }

    public function dodas()
    {
        return $this->hasMany(Doda::class);
    }
}
