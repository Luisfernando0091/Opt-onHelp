<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Requerimiento;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // ==========================================================
        // 1. TICKETS POR ESTADO (INCIDENTES + REQUERIMIENTOS)
        // ==========================================================

        // Incidentes agrupados por estado
        $estadoIncidentes = Incidente::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Requerimientos agrupados por estado
        $estadoRequerimientos = Requerimiento::selectRaw('estado, COUNT(*) as total')
            ->groupBy('estado')
            ->pluck('total', 'estado');

        // Fusionar ambos
        $tickets_por_estado = collect();

        foreach ($estadoIncidentes as $estado => $total) {
            $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
        }

        foreach ($estadoRequerimientos as $estado => $total) {
            $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
        }


        // ==========================================================
        // 2. TIEMPO PROMEDIO DE RESOLUCIÓN (SOLO INCIDENTES)
        // ==========================================================
        $incidentes_cerrados = Incidente::whereNotNull('fecha_cierre')
            ->whereIn('estado', ['Cerrado', 'Finalizado'])
            ->get();

        $tiempo_total_min = 0;
        $total_cerrados = $incidentes_cerrados->count();

        foreach ($incidentes_cerrados as $item) {
            $inicio = Carbon::parse($item->created_at);
            $fin = Carbon::parse($item->fecha_cierre);
            $tiempo_total_min += $inicio->diffInMinutes($fin);
        }

        $promedio_min = $total_cerrados > 0 ? $tiempo_total_min / $total_cerrados : 0;
        $promedio_min = round($promedio_min);

        if ($promedio_min >= 60) {
            $horas = intdiv($promedio_min, 60);
            $minutos = $promedio_min % 60;
            $tiempo_promedio = $minutos > 0 ? "{$horas} h {$minutos} min" : "{$horas} h";
        } else {
            $tiempo_promedio = "≈{$promedio_min} minutos";
        }


        // ==========================================================
        // 3. TICKETS POR MES (INCIDENTES + REQUERIMIENTOS)
        // ==========================================================
        $year = now()->year;

        // Incidentes por mes
        $incidentes_por_mes = Incidente::selectRaw("MONTH(created_at) mes, COUNT(*) total")
            ->whereYear('created_at', $year)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        // Requerimientos por mes
        $requerimientos_por_mes = Requerimiento::selectRaw("MONTH(created_at) mes, COUNT(*) total")
            ->whereYear('created_at', $year)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        // Etiquetas de meses
        $meses = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'));

        // Formar arrays de 12 meses
        $incidentes = [];
        $requerimientos = [];

        foreach (range(1, 12) as $m) {
            $incidentes[] = $incidentes_por_mes[$m] ?? 0;
            $requerimientos[] = $requerimientos_por_mes[$m] ?? 0;
        }

        // ==========================================================
        // 4. RETORNAR DATOS A LA VISTA
        // ==========================================================
        return view('home', [
            'tickets_por_estado' => $tickets_por_estado,
            'tiempo_promedio' => $tiempo_promedio,
            'meses' => $meses,
            'incidentes' => $incidentes,
            'requerimientos' => $requerimientos
        ]);
    }
}
