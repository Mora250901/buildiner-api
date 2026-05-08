<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Distrito;
use Illuminate\Http\Request;

class DistritoController extends Controller
{
    public function index()
    {
        $distritos = Distrito::where('activo', true)
            ->orderBy('nombre')
            ->get();

        return response()->json($distritos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'provincia'    => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'latitud'      => 'nullable|numeric',
            'longitud'     => 'nullable|numeric',
        ]);

        $distrito = Distrito::create($request->all());

        return response()->json($distrito, 201);
    }

    public function show(Distrito $distrito)
    {
        return response()->json($distrito->load('construcciones'));
    }

    public function update(Request $request, Distrito $distrito)
    {
        $request->validate([
            'nombre'       => 'sometimes|string|max:255',
            'provincia'    => 'nullable|string|max:255',
            'departamento' => 'nullable|string|max:255',
            'latitud'      => 'nullable|numeric',
            'longitud'     => 'nullable|numeric',
            'activo'       => 'nullable|boolean',
        ]);

        $distrito->update($request->all());

        return response()->json($distrito);
    }

    public function destroy(Distrito $distrito)
    {
        $distrito->update(['activo' => false]);
        return response()->json(['message' => 'Distrito desactivado correctamente.']);
    }
}