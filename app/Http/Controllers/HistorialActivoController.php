<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\HistorialActivo;
use Illuminate\Http\Request;
use App\Models\PiezasMantenimiento;

class HistorialActivoController extends Controller
{
    public function create($activoId)
    {
        $activo = Activo::findOrFail($activoId);
        // Traer las piezas disponibles
    $piezas = PiezasMantenimiento::orderBy('nombre')->get();

        return view('Activos.historial.create', compact('activo','piezas'));
    }

    public function store(Request $request, $activoId)
    {
        $request->validate([
            'observacion' => 'required|string',
        ]);

        HistorialActivo::create([
        'activo_id' => $activoId,
        'user_id' => auth()->id(), // Usuario logueado
        'accion' => 'Mantenimiento',
        'observacion' => $request->observacion,
            'pieza_id' => $request->pieza_id, // 

        ]);

        return redirect()
    ->route('activos.show', $activoId)
    ->with('success', 'Mantenimiento registrado correctamente!');

    }


}
