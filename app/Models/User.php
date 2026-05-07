<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    public function suscripciones()
    {
        return $this->hasMany(Suscripcion::class);
    }

    public function suscripcionActiva()
    {
        return $this->hasOne(Suscripcion::class)
            ->where('estado', 'activa')
            ->where('fecha_fin', '>=', now())
            ->latestOfMany();
    }

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class);
    }

    public function tieneAcceso(string $plan): bool
    {
        $planes = ['standard' => 1, 'pro' => 2, 'premium' => 3];
        $suscripcion = $this->suscripcionActiva;
        if (!$suscripcion) return false;
        return ($planes[$suscripcion->plan] ?? 0) >= ($planes[$plan] ?? 0);
    }
}