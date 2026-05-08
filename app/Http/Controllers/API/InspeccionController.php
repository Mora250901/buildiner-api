<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Inspeccion;
use App\Models\Construccion;
use Illuminate\Http\Request;

class InspeccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Inspeccion::with(['construccion.distrito', 'inspector', 'evidencias']);

        if ($request->construccion_id) {
            $query->where('construccion_id', $request->construccion_id);
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        return response()->json($query->orderByDesc('fecha_inspeccion')->paginate(20));
    }

    public function store(Request $request)
    {
        $request->validate([
            'construccion_id'   => 'required|exists:construcciones,id',
            'fecha_inspeccion'  => 'required|date',
            'estado_encontrado' => 'required|in:en_planos,cimientos,estructura,albañileria,acabados,culminada,paralizada',
            'avance_porcentaje' => 'nullable|integer|min:0|max:100',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
        ]);

        $data = $request->all();
        $data['user_id'] = $request->user()->id;

        $inspeccion = Inspeccion::create($data);

        // Actualizar estado y avance de la construcción
        $construccion = Construccion::find($request->construccion_id);
        $construccion->update([
            'estado'            => $request->estado_encontrado,
            'avance_porcentaje' => $request->avance_porcentaje ?? $construccion->avance_porcentaje,
        ]);

        return response()->json($inspeccion->load(['construccion', 'inspector']), 201);
    }

    public function show(Inspeccion $inspeccion)
    {
        return response()->json(
            $inspeccion->load(['construccion.distrito', 'inspector', 'evidencias'])
        );
    }

    public function update(Request $request, Inspeccion $inspeccion)
    {
        $request->validate([
            'fecha_inspeccion'  => 'sometimes|date',
            'estado_encontrado' => 'sometimes|in:en_planos,cimientos,estructura,albañileria,acabados,culminada,paralizada',
            'avance_porcentaje' => 'nullable|integer|min:0|max:100',
            'descripcion'       => 'nullable|string',
            'observaciones'     => 'nullable|string',
        ]);

        $inspeccion->update($request->all());

        return response()->json($inspeccion->load(['construccion', 'inspector']));
    }

    public function destroy(Inspeccion $inspeccion)
    {
        $inspeccion->delete();
        return response()->json(['message' => 'Inspección eliminada correctamente.']);
    }
}