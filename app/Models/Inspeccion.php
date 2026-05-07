<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    protected $fillable = [
        'construccion_id',
        'user_id',
        'fecha_inspeccion',
        'estado_encontrado',
        'avance_porcentaje',
        'descripcion',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inspeccion'  => 'date',
        'avance_porcentaje' => 'integer',
    ];

    public function construccion()
    {
        return $this->belongsTo(Construccion::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evidencias()
    {
        return $this->hasMany(Evidencia::class);
    }
}