<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Requerimiento;
use App\Models\BssCinc;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidentesExport;

class IncidenteController extends Controller
{
    /**
     * 🔹 Lista de incidentes según el rol
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            $incidentes = Incidente::with(['usuario', 'tecnico'])
                ->orderByDesc('id')
                ->get();
        } elseif ($user->hasRole('tecnico')) {
            $incidentes = Incidente::with(['usuario', 'tecnico'])
                ->orderByDesc('id')
                ->get();
        } else {
            $incidentes = Incidente::with(['usuario', 'tecnico'])
                ->where('usuario_id', $user->id)
                ->orderByDesc('id')
                ->get();
        }

        if ($request->ajax()) {
            return view('incidentes.partials.lista', compact('incidentes'))->render();
        }

        return view('incidentes.index', compact('incidentes'));
    }

    /**
     * 🔹 Crear incidente
     */
    public function create()
    {
        $tiposIncidentes = BssCinc::all();

        $tecnicos = User::role('tecnico')
            ->where('activo', 1)
            ->get();

        $ultimo = Incidente::orderBy('id', 'desc')->count();
        $nuevoCodigo = 'INC-' . str_pad(($ultimo), 4, '0', STR_PAD_LEFT);

        return view('incidentes.create', compact('tiposIncidentes', 'tecnicos', 'nuevoCodigo'));
    }

    /**
     * 🔹 Guardar incidente
     */
    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|exists:bss_cinc,CODIGO',
            'descripcion' => 'required|string',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'tecnico_id' => 'required|exists:users,id',
            'fecha_reporte' => 'required|date',
        ]);

        $tipoIncidente = BssCinc::where('CODIGO', $request->codigo)->first();

        $incidente = new Incidente();
        $incidente->usuario_id = auth()->id();

        $ultimo = Incidente::orderBy('id', 'desc')->count();
        $nuevoCodigo = 'INC-' . str_pad(($ultimo), 4, '0', STR_PAD_LEFT);

        $incidente->codigo = $nuevoCodigo;
        $incidente->titulo = $tipoIncidente->nombre_caso;
        $incidente->descripcion = $request->descripcion;
        $incidente->estado = $request->estado;
        $incidente->prioridad = $request->prioridad;
        $incidente->tecnico_id = $request->tecnico_id;
        $incidente->fecha_reporte = $request->fecha_reporte;
        $incidente->save();

        \Mail::to(auth()->user()->email)->send(new \App\Mail\IncidenteRegistradoMail($incidente));

        return redirect()->route('incidentes.index')->with('success', '✅ Incidente registrado correctamente.');
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
 * 🔹 Mostrar detalle del incidente
 */
public function show($id)
{
    $incidente = Incidente::with(['usuario', 'tecnico'])->findOrFail($id);
    return view('incidentes.show', compact('incidente'));
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

        if ($validated['estado'] === 'Finalizado') {
            $validated['fecha_cierre'] = now();
        } else {
            $validated['fecha_cierre'] = null;
        }

        $incidente->update($validated);

        return redirect()->route('incidentes.index')->with('success', '✅ Incidente actualizado correctamente.');
    }

    /**
     * 🔹 Eliminar
     */
    public function destroy($id)
    {
        $incidente = Incidente::findOrFail($id);
        $incidente->delete();

        return redirect()->route('incidentes.index')->with('success', '🗑️ Incidente eliminado correctamente.');
    }

    /**
     * 🔹 Exportar PDF con Filtro por Rol
     */
    public function exportPdf(Request $request)
    {
        $user = auth()->user();
        $tipo = $request->get('tipo', 'incidente');

        $query = $tipo === 'requerimiento'
            ? Requerimiento::with(['usuario', 'tecnico'])
            : Incidente::with(['usuario', 'tecnico']);

        // 🔥 Filtro por rol
        if ($user->hasRole('usuario')) {
            $query->where('usuario_id', $user->id);
        }

        if ($request->filled('fecha_desde'))
            $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);

        if ($request->filled('fecha_hasta'))
            $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);

        $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

        if ($incidentes->isEmpty()) {
            return back()->with('warning', '⚠️ No hay datos para exportar.');
        }

        $pdf = Pdf::loadView('incidentes.export_pdf', compact('incidentes'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('reporte_incidentes.pdf');
    }

    /**
     * 🔹 Exportar Excel con Filtro por Rol
     */
    public function exportExcel(Request $request)
    {
        $user = auth()->user();
        $tipo = $request->get('tipo', 'incidente');

        $query = $tipo === 'requerimiento'
            ? Requerimiento::with(['usuario', 'tecnico'])
            : Incidente::with(['usuario', 'tecnico']);

        // 🔥 Filtro por rol
        if ($user->hasRole('usuario')) {
            $query->where('usuario_id', $user->id);
        }

        if ($request->filled('fecha_desde'))
            $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);

        if ($request->filled('fecha_hasta'))
            $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);

        $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

        if ($incidentes->isEmpty()) {
            return back()->with('warning', '⚠️ No hay datos para exportar.');
        }

        return Excel::download(new IncidentesExport($incidentes), 'reporte_incidentes.xlsx');
    }

    /**
     * 🔹 Vista general del reporte
     */
    public function reporte(Request $request)
    {
        $user = auth()->user();
        $tipo = $request->get('tipo', 'incidente');

        $query = $tipo === 'requerimiento'
            ? Requerimiento::with(['usuario', 'tecnico'])
            : Incidente::with(['usuario', 'tecnico']);

        // 🔥 Filtro por rol
        if ($user->hasRole('usuario')) {
            $query->where('usuario_id', $user->id);
        }

        if ($request->filled('fecha_desde'))
            $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);

        if ($request->filled('fecha_hasta'))
            $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);

        $data = $query->orderBy('fecha_reporte', 'desc')->get();

        return view('reports.report', [
            'data' => $data,
            'tipo' => $tipo
        ]);
    }
}
