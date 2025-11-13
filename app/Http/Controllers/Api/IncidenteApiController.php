<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incidente;
use Illuminate\Http\Request;

class IncidenteApiController extends Controller
{
    public function index()
    {
        return response()->json(Incidente::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $incidente = Incidente::create($data);
        return response()->json($incidente, 201);
    }

    public function show($id)
    {
        $incidente = Incidente::find($id);
        if (!$incidente) {
            return response()->json(['message' => 'Incidente no encontrado'], 404);
        }
        return response()->json($incidente);
    }

    public function update(Request $request, $id)
    {
        $incidente = Incidente::find($id);
        if (!$incidente) {
            return response()->json(['message' => 'Incidente no encontrado'], 404);
        }

        $incidente->update($request->all());
        return response()->json($incidente);
    }

    public function destroy($id)
    {
        $incidente = Incidente::find($id);
        if (!$incidente) {
            return response()->json(['message' => 'Incidente no encontrado'], 404);
        }

        $incidente->delete();
        return response()->json(['message' => 'Incidente eliminado correctamente']);
    }
}
