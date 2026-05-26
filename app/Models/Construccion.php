<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Construccion extends Model
{
    protected $table = 'construcciones';

    protected $fillable = [
        'distrito_id',
        'direccion',
        'latitud',
        'longitud',
        'propietario',
        'ingeniero_responsable',
        'numero_pisos',
        'estado',
        'tiene_licencia',
        'numero_licencia',
        'fecha_inicio',
        'fecha_estimada_fin',
        'avance_porcentaje',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'tiene_licencia'     => 'boolean',
        'activo'             => 'boolean',
        'latitud'            => 'decimal:7',
        'longitud'           => 'decimal:7',
        'fecha_inicio'       => 'date',
        'fecha_estimada_fin' => 'date',
    ];

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

    public function inspecciones()
    {
        return $this->hasMany(Inspeccion::class);
    }

    public function ultimaInspeccion()
    {
        return $this->hasOne(Inspeccion::class)->latestOfMany();
    }
}