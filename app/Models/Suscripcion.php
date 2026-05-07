<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Suscripcion extends Model
{
    protected $fillable = [
        'user_id',
        'plan',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'monto',
        'metodo_pago',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
        'monto'        => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function estaActiva(): bool
    {
        return $this->estado === 'activa' && $this->fecha_fin >= now();
    }
}