<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Incidente;
use Illuminate\Http\Request;

class IncidenteApiController extends Controller
{
    // Listar todos los incidentes
    public function index()
    {
        return response()->json(Incidente::all());
    }

    // Obtener información de un incidente
    public function show($id)
    {
        $incidente = Incidente::find($id);

        if (!$incidente) {
            return response()->json(['error' => 'Incidente no encontrado'], 404);
        }

        return response()->json($incidente);
    }

    // Actualizar solo solución y estado
    public function updateSolucion(Request $request, $id)
    {
        $incidente = Incidente::find($id);

        if (!$incidente) {
            return response()->json(['error' => 'Incidente no encontrado'], 404);
        }

        $data = $request->validate([
            'solucion' => 'required|string',
            'estado'   => 'required|string',
        ]);

        $incidente->update($data);

        return response()->json([
            'message'   => 'Incidente actualizado correctamente',
            'incidente' => $incidente
        ]);
    }
}
