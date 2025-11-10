<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\BssCinc; // 👈 importante: importa el modelo
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidentesExport; // la
class IncidenteController extends Controller
{
    /**
     * 🔹 Mostrar lista de incidentes
     */
 public function index(Request $request)
{
    $user = auth()->user();

    // 🔹 Filtramos los incidentes según el rol del usuario
    if ($user->hasRole('admin')) {
        // El admin ve todos los tickets
        $incidentes = Incidente::with(['usuario', 'tecnico'])
            ->orderByDesc('id')
            ->get();

    } elseif ($user->hasRole('tecnico')) {
        // El técnico solo ve los tickets asignados a él
        $incidentes = Incidente::with(['usuario', 'tecnico'])
            ->where('tecnico_id', $user->id)
            ->orderByDesc('id')
            ->get();

    } elseif ($user->hasRole('usuario')) {
        // El usuario solo ve los tickets que él mismo creó
        $incidentes = Incidente::with(['usuario', 'tecnico'])
            ->where('usuario_id', $user->id)
            ->orderByDesc('id')
            ->get();

    } else {
        // Por si acaso, si no tiene rol asignado
        $incidentes = collect(); // devuelve una colección vacía
    }

    // Si es una petición AJAX (para actualizar la tabla)
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

// ...

// ...

public function exportPdf(Request $request)
{
    $query = Incidente::with(['usuario', 'tecnico']);

    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
    }

    if ($request->filled('mes')) {
        $query->whereMonth('fecha_reporte', $request->mes);
    }

    $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

    if ($incidentes->isEmpty()) {
        return back()->with('warning', '⚠️ No hay incidentes para exportar con los filtros seleccionados.');
    }

    // Cargar tu vista PDF
$pdf = Pdf::loadView('incidentes.export_pdf', compact('incidentes'))
        ->setPaper('a4', 'landscape'); // horizontal

    // Descargar el archivo
    return $pdf->download('reporte_incidentes.pdf');
}


public function exportExcel(Request $request)
{
    $query = Incidente::with(['usuario', 'tecnico']);

    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
    }

    if ($request->filled('mes')) {
        $query->whereMonth('fecha_reporte', $request->mes);
    }

    $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

    if ($incidentes->isEmpty()) {
        return back()->with('warning', '⚠️ No hay incidentes para exportar con los filtros seleccionados.');
    }

    return Excel::download(new \App\Exports\IncidentesExport($incidentes), 'reporte_incidentes.xlsx');
}

public function reporte(Request $request)
{
    $query = \App\Models\Incidente::with(['usuario', 'tecnico']);

    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
    }

    if ($request->filled('mes')) {
        $query->whereMonth('fecha_reporte', $request->mes);
    }

    $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

    return view('reports.report', compact('incidentes'));
}



}
