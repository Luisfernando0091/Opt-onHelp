<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\BssCinc; // 👈 importante: importa el modelo
use App\Models\User;

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
    $tiposIncidentes = BssCinc::all();

    // ✅ Solo usuarios con el rol "tecnico"
    $tecnicos = User::role('tecnico')
        ->where('activo', 1)
        ->get();

    // Generar el nuevo código del ticket
    $ultimo = \App\Models\Incidente::orderBy('id', 'desc')->first();
    $nuevoCodigo = 'INC-' . str_pad(($ultimo ? $ultimo->id + 1 : 1), 4, '0', STR_PAD_LEFT);

    return view('incidentes.create', compact('tiposIncidentes', 'tecnicos', 'nuevoCodigo'));
}


        /**
     * 🔹 Guardar nuevo incidente
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo' => 'required|exists:bss_cinc,CODIGO',
            'descripcion' => 'nullable|string',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'fecha_reporte' => 'required|date',
            'tecnico_id' => 'nullable|exists:users,id', // 👈 nuevo

        ]);

        // 1️⃣ Buscar el tipo de incidente seleccionado (A-01, etc.)
        $tipo = BssCinc::where('CODIGO', $validated['codigo'])->first();

        // 2️⃣ Generar código único para el nuevo incidente (ej. INC-0001)
        $ultimo = \App\Models\Incidente::orderBy('id', 'desc')->first();
        $nuevoCodigo = 'INC-' . str_pad(($ultimo ? $ultimo->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        // 3️⃣ Crear el incidente
        $incidente = Incidente::create([
            'codigo' => $nuevoCodigo, // 👈 Código único del ticket
            'titulo' => $tipo->nombre_caso, // 👈 Nombre del tipo de incidente
            'descripcion' => $validated['descripcion'] ?? '',
            'estado' => 'Pendiente',
            'prioridad' => $validated['prioridad'],
            'usuario_id' => auth()->id(),
            'tecnico_id' => $request->input('tecnico_id'), // ✅ se guarda el técnico asignado
            'fecha_reporte' => $validated['fecha_reporte'],
            'solucion' => null,
        ]);

        return redirect()
            ->route('incidentes.index')
            ->with('success', '✅ Incidente registrado correctamente.');
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
