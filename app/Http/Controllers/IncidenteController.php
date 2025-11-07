<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;

class IncidenteController extends Controller
{
    /**
     * 🔹 Mostrar lista de incidentes
     */
    public function index(Request $request)
    {
        $incidentes = Incidente::with(['usuario', 'tecnico'])
            ->orderByDesc('id')
            ->get();

        // Si la petición es AJAX (para recargar tabla)
        if ($request->ajax()) {
            return view('incidentes.partials.lista', compact('incidentes'))->render();
        }

        return view('incidentes.index', compact('incidentes'));
    }

    /**
     * 🔹 Mostrar formulario para crear incidente
     */
    public function create()
    {
        return view('incidentes.create');
    }

    /**
     * 🔹 Guardar nuevo incidente
     */
    public function store(Request $request)
    {
        // ✅ Validar entrada (sin 'codigo' ni 'usuario_id', se generan automáticamente)
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'prioridad' => 'required|in:Baja,Media,Alta,Crítica',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        // ✅ Generar código automático (INC-0001, INC-0002, etc.)
        $ultimo = Incidente::orderBy('id', 'desc')->first();
        $nuevoCodigo = 'INC-' . str_pad(($ultimo ? $ultimo->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        // ✅ Crear incidente
        Incidente::create([
            'codigo' => $nuevoCodigo,
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'] ?? '',
            'estado' => 'Pendiente', // 👈 compatible con tu ENUM
            'prioridad' => $validated['prioridad'],
            'usuario_id' => auth()->id(), // usuario autenticado
            'tecnico_id' => $validated['tecnico_id'] ?? null,
            'fecha_reporte' => now(),
            'solucion' => null,
        ]);

        return redirect()
            ->route('incidentes.index')
            ->with('success', '✅ Incidente creado correctamente.');
    }

    /**
     * 🔹 Mostrar un incidente
     */
    public function show($id)
    {
        $incidente = Incidente::with(['usuario', 'tecnico'])->findOrFail($id);
        return view('incidentes.show', compact('incidente'));
    }

    /**
     * 🔹 Editar incidente
     */
    public function edit($id)
    {
        $incidente = Incidente::findOrFail($id);
        return view('incidentes.edit', compact('incidente'));
    }

    /**
     * 🔹 Actualizar incidente
     */
    public function update(Request $request, $id)
    {
        $incidente = Incidente::findOrFail($id);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Pendiente,En proceso,A la espera,Finalizado',
            'prioridad' => 'required|in:Baja,Media,Alta,Crítica',
            'tecnico_id' => 'nullable|exists:users,id',
            'solucion' => 'nullable|string',
        ]);

        // ✅ Si el estado cambia a "Finalizado", se registra la fecha de cierre
        if ($validated['estado'] === 'Finalizado' && !$incidente->fecha_cierre) {
            $validated['fecha_cierre'] = now();
        }

        $incidente->update($validated);

        return redirect()
            ->route('incidentes.index')
            ->with('success', '✅ Incidente actualizado correctamente.');
    }

    /**
     * 🔹 Eliminar incidente
     */
    public function destroy($id)
    {
        $incidente = Incidente::findOrFail($id);
        $incidente->delete();

        return redirect()
            ->route('incidentes.index')
            ->with('success', '🗑️ Incidente eliminado correctamente.');
    }
}
