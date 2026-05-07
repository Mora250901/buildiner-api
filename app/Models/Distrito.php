<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
    protected $fillable = [
        'nombre',
        'provincia',
        'departamento',
        'latitud',
        'longitud',
        'activo',
    ];

    protected $casts = [
        'activo'   => 'boolean',
        'latitud'  => 'decimal:7',
        'longitud' => 'decimal:7',
    ];

    public function construcciones()
    {
        return $this->hasMany(Construccion::class);
    }
}