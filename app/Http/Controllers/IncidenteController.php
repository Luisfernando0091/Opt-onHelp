<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\BssCinc; // 👈 importante: importa el modelo
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidentesExport; // la
use Illuminate\Support\Facades\Mail;
use App\Mail\IncidenteRegistradoMail;

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
    // Tipos de incidente (tabla bss_cinc)
    $tiposIncidentes = \App\Models\BssCinc::all();

    // Técnicos con rol 'tecnico' activos
    $tecnicos = \App\Models\User::role('tecnico')
        ->where('activo', 1)
        ->get();

    // Generar nuevo código
    $ultimo = \App\Models\Incidente::orderBy('id', 'desc')->count();
    $nuevoCodigo = 'INC-' . str_pad(($ultimo), 4, '0', STR_PAD_LEFT);

    return view('incidentes.create', compact('tiposIncidentes', 'tecnicos', 'nuevoCodigo'));
}


        /**
     * 🔹 Guardar nuevo incidente
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

        // Buscar tipo de incidente
        $tipoIncidente = \App\Models\BssCinc::where('CODIGO', $request->codigo)->first();

        // Crear incidente
        $incidente = new \App\Models\Incidente();
        $incidente->usuario_id = auth()->id();

        // ✅ Generar código único incremental
        $ultimo = \App\Models\Incidente::orderBy('id', 'desc')->count();
        $nuevoCodigo = 'INC-' . str_pad(($ultimo), 4, '0', STR_PAD_LEFT);

        $incidente->codigo = $nuevoCodigo;

        // Guardar resto de datos
        $incidente->titulo = $tipoIncidente->nombre_caso;
        $incidente->descripcion = $request->descripcion;
        $incidente->estado = $request->estado;
        $incidente->prioridad = $request->prioridad;
        $incidente->tecnico_id = $request->tecnico_id;
        $incidente->fecha_reporte = $request->fecha_reporte;
        $incidente->save();

        // Enviar correo
        $user = auth()->user();
        // try{

       \Mail::to($user->email)->send(new \App\Mail\IncidenteRegistradoMail($incidente));
                // dd($correo);
        // } catch(\Exception $e) {
        //     // Manejar el error de envío de correo (opcional)
        //     dd(''. $e->getMessage());
        // }

        return redirect()
            ->route('incidentes.index')
            ->with('success', '✅ Incidente registrado correctamente y correo enviado.');
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

    // ✅ Si el estado cambia a "Finalizado" (cerrado)
    if ($validated['estado'] === 'Finalizado') {
        $validated['fecha_cierre'] = now();
    } 
    // ✅ Si el estado NO es finalizado, eliminar la fecha de cierre anterior
    else {
        $validated['fecha_cierre'] = null;
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
   $tipo = $request->get('tipo', 'incidente'); // por defecto incidente

    if ($tipo === 'requerimiento') {

        $query = \App\Models\Requerimiento::with(['usuario', 'tecnico']);

    } else {

        // tipo incidente
        $query = \App\Models\Incidente::with(['usuario', 'tecnico']);
    }


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
// public function exportPdf(Request $request)
// {
//     $tipo = $request->get('tipo', 'incidente');

//     if ($tipo === 'requerimiento') {
//         $query = \App\Models\Requerimiento::with(['usuario', 'tecnico']);
//     } else {
//         $query = \App\Models\Incidente::with(['usuario', 'tecnico']);
//     }

//     // Filtros
//     if ($request->filled('fecha_desde')) {
//         $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
//     }
//     if ($request->filled('fecha_hasta')) {
//         $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
//     }
//     if ($request->filled('mes')) {
//         $query->whereMonth('fecha_reporte', $request->mes);
//     }

//     $data = $query->get();

//     if ($data->isEmpty()) {
//         return back()->with('warning', '⚠️ No hay datos para exportar.');
//     }

//     // Usa la misma vista para ambos
//     $pdf = Pdf::loadView('reports.pdf_general', [
//         'data' => $data,
//         'tipo'  => $tipo
//     ])->setPaper('a4', 'landscape');

//     return $pdf->download("reporte_{$tipo}.pdf");
// }



public function exportExcel(Request $request)
{
 $tipo = $request->get('tipo', 'incidente'); // por defecto incidente

    if ($tipo === 'requerimiento') {

        $query = \App\Models\Requerimiento::with(['usuario', 'tecnico']);

    } else {

        // tipo incidente
        $query = \App\Models\Incidente::with(['usuario', 'tecnico']);
    }

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
// public function exportExcel(Request $request)
// {
//     return Excel::download(
//         new \App\Exports\GeneralExport(
//             tipo: $request->tipo ?? 'incidente',
//             filtros: $request->all()
//         ),
//         "reporte_{$request->tipo}.xlsx"
//     );
// }

// 14 11 / 25 SE CAMBIO  

// public function reporte(Request $request)
// {
//     $query = \App\Models\Incidente::with(['usuario', 'tecnico']);

//     if ($request->filled('fecha_desde')) {
//         $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
//     }

//     if ($request->filled('fecha_hasta')) {
//         $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
//     }

//     if ($request->filled('mes')) {
//         $query->whereMonth('fecha_reporte', $request->mes);
//     }

//     $incidentes = $query->orderBy('fecha_reporte', 'desc')->get();

//     return view('reports.report', compact('incidentes'));
// }
public function reporte(Request $request)
{
    // tipo = incidente | requerimiento
    $tipo = $request->get('tipo', 'incidente'); // por defecto incidente

    if ($tipo === 'requerimiento') {

        $query = \App\Models\Requerimiento::with(['usuario', 'tecnico']);

    } else {

        // tipo incidente
        $query = \App\Models\Incidente::with(['usuario', 'tecnico']);
    }

    // 🔹 Filtros iguales para ambos tipos
    if ($request->filled('fecha_desde')) {
        $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
    }

    if ($request->filled('fecha_hasta')) {
        $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
    }

    if ($request->filled('mes')) {
        $query->whereMonth('fecha_reporte', $request->mes);
    }

    // 🔹 Ejecutar consulta
    $data = $query->orderBy('fecha_reporte', 'desc')->get();

    return view('reports.report', [
        'data' => $data,
        'tipo' => $tipo
    ]);
}



}