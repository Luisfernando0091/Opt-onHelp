<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Requerimiento;
use Illuminate\Http\Request;
use App\Events\Requerimientocreado;

class RequerimientoApiController extends Controller
{
    public function index()
    {
        return response()->json(
            Requerimiento::with(['usuario', 'tecnico', 'categoria'])->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id'  => 'required|integer',
        ]);

        $requerimiento = Requerimiento::create($data);

        event(new Requerimientocreado($requerimiento));

        return response()->json([
            'message'   => 'Requerimiento registrado y notificación enviada',
            'incidente' => $requerimiento
        ], 201);
    }

    public function updateSolucion(Request $request, $id)
    {
        $data = $request->validate([
            'estado' => 'required|string',
            'solucion' => 'nullable|string',
        ]);

        $incidente = Requerimiento::find($id);

        if (!$incidente) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        $incidente->estado   = $data['estado'];
        $incidente->solucion = $data['solucion'] ?? $incidente->solucion;

        if ($data['estado'] === 'Finalizado') {
            $incidente->fecha_cierre = now();
        } else {
            $incidente->fecha_cierre = null;
        }

        $incidente->save();

        return response()->json([
            'message'   => 'Incidente actualizado correctamente',
            'incidente' => $incidente
        ]);
    }

    public function show($id)
    {
        $incidente = Requerimiento::with(['usuario','tecnico','categoria'])->find($id);

        if (!$incidente) {
            return response()->json(['error' => 'Requerimiento no encontrado'], 404);
        }

        return response()->json($incidente);
    }
}
