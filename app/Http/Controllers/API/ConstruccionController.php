<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Construccion;
use Illuminate\Http\Request;

class ConstruccionController extends Controller
{
    public function index(Request $request)
    {
        $query = Construccion::with(['distrito', 'ultimaInspeccion'])
            ->where('activo', true);

        if ($request->distrito_id) {
            $query->where('distrito_id', $request->distrito_id);
        }

        if ($request->estado) {
            $query->where('estado', $request->estado);
        }

        if ($request->tiene_licencia !== null) {
            $query->where('tiene_licencia', $request->boolean('tiene_licencia'));
        }

        return response()->json($query->orderByDesc('created_at')->paginate(20));
    }

    public function store(Request $request)
    {
        $request->validate([
            'distrito_id'           => 'required|exists:distritos,id',
            'direccion'             => 'required|string|max:500',
            'latitud'               => 'nullable|numeric',
            'longitud'              => 'nullable|numeric',
            'propietario'           => 'nullable|string|max:255',
            'ingeniero_responsable' => 'nullable|string|max:255',
            'numero_pisos'          => 'nullable|integer|min:1',
            'estado'                => 'nullable|in:en_planos,cimientos,estructura,albañileria,acabados,culminada,paralizada',
            'tiene_licencia'        => 'nullable|boolean',
            'numero_licencia'       => 'nullable|string|max:100',
            'fecha_inicio'          => 'nullable|date',
            'fecha_estimada_fin'    => 'nullable|date',
            'avance_porcentaje'     => 'nullable|integer|min:0|max:100',
            'observaciones'         => 'nullable|string',
        ]);

        $construccion = Construccion::create($request->all());

        return response()->json(
            Construccion::with('distrito')->find($construccion->id), 201
        );
    }

    public function show($id)
    {
        $construccion = Construccion::with([
            'distrito',
            'inspecciones.evidencias',
            'inspecciones.inspector'
        ])->find($id);

        if (!$construccion) {
            return response()->json(['message' => 'No encontrado.'], 404);
        }

        return response()->json($construccion);
    }

    public function update(Request $request, $id)
    {
        $construccion = Construccion::find($id);

        if (!$construccion) {
            return response()->json(['message' => 'No encontrado.'], 404);
        }

        $request->validate([
            'distrito_id'           => 'sometimes|exists:distritos,id',
            'direccion'             => 'sometimes|string|max:500',
            'latitud'               => 'nullable|numeric',
            'longitud'              => 'nullable|numeric',
            'propietario'           => 'nullable|string|max:255',
            'ingeniero_responsable' => 'nullable|string|max:255',
            'numero_pisos'          => 'nullable|integer|min:1',
            'estado'                => 'nullable|in:en_planos,cimientos,estructura,albañileria,acabados,culminada,paralizada',
            'tiene_licencia'        => 'nullable|boolean',
            'numero_licencia'       => 'nullable|string|max:100',
            'fecha_inicio'          => 'nullable|date',
            'fecha_estimada_fin'    => 'nullable|date',
            'avance_porcentaje'     => 'nullable|integer|min:0|max:100',
            'observaciones'         => 'nullable|string',
        ]);

        $construccion->update($request->all());

        return response()->json(
            Construccion::with('distrito')->find($id)
        );
    }

    public function destroy($id)
    {
        $construccion = Construccion::find($id);

        if (!$construccion) {
            return response()->json(['message' => 'No encontrado.'], 404);
        }

        $construccion->update(['activo' => false]);
        return response()->json(['message' => 'Construcción desactivada correctamente.']);
    }
}