<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Requerimiento;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\IncidentesExport;

class ReporteController extends Controller
{
    // Mostrar vista de reportes
    public function index(Request $request)
    {   
        $user = auth()->user();
        $isAdmin=$user->hasRole('admin');
        $isTecnico=$user->hasRole('tecnico');

        $tipo = $request->tipo ?? 'incidente';

        // FILTROS BÁSICOS
        $query = ($tipo == 'incidente') ? Incidente::query() : Requerimiento::query();
    
        if (!$isAdmin && !$isTecnico) {
        $query->where('usuario_id', $user->id);
        }


        if ($request->fecha_desde) {
            $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
        }

        if ($request->fecha_hasta) {
            $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
        }

        if ($request->mes) {
            $query->whereMonth('fecha_reporte', $request->mes);
        }


        $data = $query->with(['usuario', 'tecnico'])->get();
        return view('reports', compact('data', 'tipo'));
    }

    // EXPORTAR A PDF
    public function exportPdf(Request $request)
    {   $user = auth()->user();
        $isAdmin=$user->hasRole('admin');
        $isTecnico=$user->hasRole('tecnico');

        $tipo = $request->tipo ?? 'incidente';

        $query = ($tipo == 'incidente') ? Incidente::query() : Requerimiento::query();
         
        if (!$isAdmin && !$isTecnico) {
        $query->where('usuario_id', $user->id);
    }


        if ($request->fecha_desde) $query->whereDate('fecha_reporte', '>=', $request->fecha_desde);
        if ($request->fecha_hasta) $query->whereDate('fecha_reporte', '<=', $request->fecha_hasta);
        if ($request->mes) $query->whereMonth('fecha_reporte', $request->mes);

        $data = $query->with(['usuario', 'tecnico'])->get();

        $pdf = PDF::loadView('exports.report_pdf', [
            'data' => $data,
            'tipo' => $tipo
        ]);

        return $pdf->download('reporte_'.$tipo.'.pdf');
    }

    // EXPORTAR A EXCEL
    public function exportExcel(Request $request)
    {
        return Excel::download(
            new IncidentesExport($request),
            'reporte_tickets.xlsx'
        );
    }
}
