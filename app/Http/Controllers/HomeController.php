<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\Requerimiento; // ✅ importante
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
        // === Contadores por estado ===
        $pendientes = Incidente::where('estado', 'Pendiente')->count();
        $en_proceso = Incidente::where('estado', 'En proceso')->count();
        $cerrados = Incidente::whereIn('estado', ['Cerrado', 'Finalizado'])->count();

        // === Calcular tiempo promedio de resolución ===
        $incidentes_cerrados = Incidente::whereNotNull('fecha_cierre')
            ->whereIn('estado', ['Cerrado', 'Finalizado'])
            ->get();

        $tiempo_total_minutos = 0;
        $total_casos_cerrados = $incidentes_cerrados->count();

        foreach ($incidentes_cerrados as $incidente) {
            $inicio = Carbon::parse($incidente->created_at);
            $fin = Carbon::parse($incidente->fecha_cierre);
            $tiempo_total_minutos += $inicio->diffInMinutes($fin);
        }

        $promedio_minutos = $total_casos_cerrados > 0 ? ($tiempo_total_minutos / $total_casos_cerrados) : 0;
        $promedio_minutos_round = (int) round($promedio_minutos);

        if ($promedio_minutos_round >= 60) {
            $horas = intdiv($promedio_minutos_round, 60);
            $minutos = $promedio_minutos_round % 60;
            $tiempo_promedio = $minutos > 0 ? "{$horas} h {$minutos} min" : "{$horas} h";
        } else {
            $tiempo_promedio = "≈{$promedio_minutos_round} minutos";
        }

        // === 📈 Datos para el AreaChart ===
        $year = now()->year;

        // --- Incidentes ---
        $incidentes_por_mes = Incidente::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        // --- Requerimientos ---
        $requerimientos_por_mes = Requerimiento::select(
                DB::raw('MONTH(created_at) as mes'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy('mes')
            ->pluck('total', 'mes');

        // --- Generar arreglos de 12 meses ---
        $meses = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'));
        $incidentes = [];
        $requerimientos = [];

        foreach (range(1, 12) as $i) {
            $incidentes[] = $incidentes_por_mes[$i] ?? 0;
            $requerimientos[] = $requerimientos_por_mes[$i] ?? 0;
        }

        // --- Enviar datos a la vista ---
        return view('home', compact(
            'pendientes',
            'en_proceso',
            'cerrados',
            'tiempo_promedio',
            'meses',
            'incidentes',
            'requerimientos'
        ));
    }
}
