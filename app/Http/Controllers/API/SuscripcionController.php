<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Suscripcion;
use App\Models\User;
use Illuminate\Http\Request;

class SuscripcionController extends Controller
{
    public function index()
    {
        $suscripciones = Suscripcion::with('user')
            ->orderByDesc('created_at')
            ->get();

        return response()->json($suscripciones);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'      => 'required|exists:users,id',
            'plan'         => 'required|in:standard,pro,premium',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'required|date|after:fecha_inicio',
            'monto'        => 'required|numeric|min:0',
            'metodo_pago'  => 'nullable|string|max:100',
        ]);

        // Cancelar suscripción activa anterior si existe
        Suscripcion::where('user_id', $request->user_id)
            ->where('estado', 'activa')
            ->update(['estado' => 'cancelada']);

        $suscripcion = Suscripcion::create([
            'user_id'      => $request->user_id,
            'plan'         => $request->plan,
            'estado'       => 'activa',
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'monto'        => $request->monto,
            'metodo_pago'  => $request->metodo_pago,
        ]);

        return response()->json($suscripcion->load('user'), 201);
    }

    public function show($id)
    {
        $suscripcion = Suscripcion::with('user')->find($id);

        if (!$suscripcion) {
            return response()->json(['message' => 'No encontrado.'], 404);
        }

        return response()->json($suscripcion);
    }

    public function cancelar($id)
    {
        $suscripcion = Suscripcion::find($id);

        if (!$suscripcion) {
            return response()->json(['message' => 'No encontrado.'], 404);
        }

        $suscripcion->update(['estado' => 'cancelada']);

        return response()->json(['message' => 'Suscripción cancelada correctamente.']);
    }

    public function miSuscripcion(Request $request)
    {
        $suscripcion = Suscripcion::where('user_id', $request->user()->id)
            ->where('estado', 'activa')
            ->where('fecha_fin', '>=', now())
            ->latest()
            ->first();

        return response()->json($suscripcion);
    }
}