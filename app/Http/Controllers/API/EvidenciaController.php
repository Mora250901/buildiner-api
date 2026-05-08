<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Evidencia;
use Illuminate\Http\Request;

class EvidenciaController extends Controller
{
    public function index(Request $request)
    {
        $query = Evidencia::with('inspeccion');

        if ($request->inspeccion_id) {
            $query->where('inspeccion_id', $request->inspeccion_id);
        }

        return response()->json($query->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'inspeccion_id' => 'required|exists:inspecciones,id',
            'imagen'        => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
            'descripcion'   => 'nullable|string|max:500',
            'latitud'       => 'nullable|numeric',
            'longitud'      => 'nullable|numeric',
        ]);

        $path = $request->file('imagen')->store('evidencias', 'public');

        $evidencia = Evidencia::create([
            'inspeccion_id' => $request->inspeccion_id,
            'imagen'        => $path,
            'descripcion'   => $request->descripcion,
            'latitud'       => $request->latitud,
            'longitud'      => $request->longitud,
        ]);

        return response()->json($evidencia, 201);
    }

    public function show(Evidencia $evidencia)
    {
        return response()->json($evidencia->load('inspeccion'));
    }

    public function update(Request $request, Evidencia $evidencia)
    {
        $request->validate([
            'descripcion' => 'nullable|string|max:500',
            'latitud'     => 'nullable|numeric',
            'longitud'    => 'nullable|numeric',
        ]);

        $evidencia->update($request->only(['descripcion', 'latitud', 'longitud']));

        return response()->json($evidencia);
    }

    public function destroy(Evidencia $evidencia)
    {
        \Storage::disk('public')->delete($evidencia->imagen);
        $evidencia->delete();
        return response()->json(['message' => 'Evidencia eliminada correctamente.']);
    }
}