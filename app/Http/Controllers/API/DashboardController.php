<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Construccion;
use App\Models\Inspeccion;
use App\Models\Distrito;
use App\Models\User;

class DashboardController extends Controller
{
    public function metricas()
    {
        $totalConstrucciones = Construccion::where('activo', true)->count();
        $sinLicencia         = Construccion::where('activo', true)->where('tiene_licencia', false)->count();
        $culminadas          = Construccion::where('activo', true)->where('estado', 'culminada')->count();
        $paralizadas         = Construccion::where('activo', true)->where('estado', 'paralizada')->count();
        $totalInspecciones   = Inspeccion::count();
        $totalDistritos      = Distrito::where('activo', true)->count();
        $totalUsuarios       = User::count();

        $porEstado = Construccion::where('activo', true)
            ->selectRaw('estado, count(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        $recientes = Construccion::with('distrito')
            ->where('activo', true)
            ->orderByDesc('created_at')
            ->take(5)
            ->get(['id', 'direccion', 'estado', 'avance_porcentaje', 'distrito_id']);

        return response()->json([
            'total_construcciones' => $totalConstrucciones,
            'sin_licencia'         => $sinLicencia,
            'culminadas'           => $culminadas,
            'paralizadas'          => $paralizadas,
            'total_inspecciones'   => $totalInspecciones,
            'total_distritos'      => $totalDistritos,
            'total_usuarios'       => $totalUsuarios,
            'por_estado'           => $porEstado,
            'recientes'            => $recientes,
        ]);
    }
}