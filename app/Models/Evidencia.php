<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    protected $fillable = [
        'inspeccion_id',
        'imagen',
        'descripcion',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'latitud'  => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    public function inspeccion()
    {
        return $this->belongsTo(Inspeccion::class);
    }
}