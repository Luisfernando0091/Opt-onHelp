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

    // public function index()
    // {
    //     // ==========================================================
    //     // 1. TICKETS POR ESTADO (INCIDENTES + REQUERIMIENTOS)
    //     // ==========================================================

    //     // Incidentes agrupados por estado
    //     $estadoIncidentes = Incidente::selectRaw('estado, COUNT(*) as total')
    //         ->groupBy('estado')
    //         ->pluck('total', 'estado');

    //     // Requerimientos agrupados por estado
    //     $estadoRequerimientos = Requerimiento::selectRaw('estado, COUNT(*) as total')
    //         ->groupBy('estado')
    //         ->pluck('total', 'estado');

    //     // Fusionar ambos
    //     $tickets_por_estado = collect();

    //     foreach ($estadoIncidentes as $estado => $total) {
    //         $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
    //     }

    //     foreach ($estadoRequerimientos as $estado => $total) {
    //         $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
    //     }


    //     // ==========================================================
    //     // 2. TIEMPO PROMEDIO DE RESOLUCIÓN (SOLO INCIDENTES)
    //     // ==========================================================
    //     $incidentes_cerrados = Incidente::whereNotNull('fecha_cierre')
    //         ->whereIn('estado', ['Cerrado', 'Finalizado'])
    //         ->get();

    //     $tiempo_total_min = 0;
    //     $total_cerrados = $incidentes_cerrados->count();

    //     foreach ($incidentes_cerrados as $item) {
    //         $inicio = Carbon::parse($item->created_at);
    //         $fin = Carbon::parse($item->fecha_cierre);
    //         $tiempo_total_min += $inicio->diffInMinutes($fin);
    //     }

    //     $promedio_min = $total_cerrados > 0 ? $tiempo_total_min / $total_cerrados : 0;
    //     $promedio_min = round($promedio_min);

    //     if ($promedio_min >= 60) {
    //         $horas = intdiv($promedio_min, 60);
    //         $minutos = $promedio_min % 60;
    //         $tiempo_promedio = $minutos > 0 ? "{$horas} h {$minutos} min" : "{$horas} h";
    //     } else {
    //         $tiempo_promedio = "≈{$promedio_min} minutos";
    //     }


    //     // ==========================================================
    //     // 3. TICKETS POR MES (INCIDENTES + REQUERIMIENTOS)
    //     // ==========================================================
    //     $year = now()->year;

    //     // Incidentes por mes
    //     $incidentes_por_mes = Incidente::selectRaw("MONTH(created_at) mes, COUNT(*) total")
    //         ->whereYear('created_at', $year)
    //         ->groupBy('mes')
    //         ->pluck('total', 'mes');

    //     // Requerimientos por mes
    //     $requerimientos_por_mes = Requerimiento::selectRaw("MONTH(created_at) mes, COUNT(*) total")
    //         ->whereYear('created_at', $year)
    //         ->groupBy('mes')
    //         ->pluck('total', 'mes');

    //     // Etiquetas de meses
    //     $meses = collect(range(1, 12))->map(fn($m) => Carbon::create()->month($m)->format('M'));

    //     // Formar arrays de 12 meses
    //     $incidentes = [];
    //     $requerimientos = [];

    //     foreach (range(1, 12) as $m) {
    //         $incidentes[] = $incidentes_por_mes[$m] ?? 0;
    //         $requerimientos[] = $requerimientos_por_mes[$m] ?? 0;
    //     }

    //     // ==========================================================
    //     // 4. RETORNAR DATOS A LA VISTA
    //     // ==========================================================
    //     return view('home', [
    //         'tickets_por_estado' => $tickets_por_estado,
    //         'tiempo_promedio' => $tiempo_promedio,
    //         'meses' => $meses,
    //         'incidentes' => $incidentes,
    //         'requerimientos' => $requerimientos
    //     ]);
    // }
   public function index()
{
    $user = auth()->user();

    // Detectar correctamente el rol usando Spatie
    $isAdmin = $user->hasRole('admin' );
    $isTecnico = $user->hasRole('tecnico');

    // Consultas base
    $incQuery = Incidente::query();
    $reqQuery = Requerimiento::query();

    // Si NO es admin → ver solo los tickets creados por el usuario
    if (!$isAdmin && !$isTecnico) {
        $incQuery->where('usuario_id', $user->id);
        $reqQuery->where('usuario_id', $user->id);
    }

    // ==========================================================
    // 1. TICKETS POR ESTADO (INCIDENTES + REQUERIMIENTOS)
    // ==========================================================

    $estadoIncidentes = $incQuery
        ->selectRaw('estado, COUNT(*) as total')
        ->groupBy('estado')
        ->pluck('total', 'estado');

    $estadoRequerimientos = $reqQuery
        ->selectRaw('estado, COUNT(*) as total')
        ->groupBy('estado')
        ->pluck('total', 'estado');

    $tickets_por_estado = collect();

    foreach ($estadoIncidentes as $estado => $total) {
        $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
    }

    foreach ($estadoRequerimientos as $estado => $total) {
        $tickets_por_estado[$estado] = ($tickets_por_estado[$estado] ?? 0) + $total;
    }

    // ==========================================================
    // 2. TIEMPO PROMEDIO DE RESOLUCIÓN (INCIDENTES)
    // ==========================================================

    // $incidentes_cerrados = $incQuery
    //     ->whereNotNull('fecha_cierre')
    //     ->whereIn('estado', ['Cerrado', 'Finalizado'])
    //     ->get();

    // $tiempo_total_min = 0;
    // $total_cerrados = $incidentes_cerrados->count();

    // foreach ($incidentes_cerrados as $item) {
    //     $inicio = \Carbon\Carbon::parse($item->created_at);
    //     $fin = \Carbon\Carbon::parse($item->fecha_cierre);
    //     $tiempo_total_min += $inicio->diffInMinutes($fin);
    // }

    // $promedio_min = $total_cerrados > 0 ? round($tiempo_total_min / $total_cerrados) : 0;

    // if ($promedio_min >= 60) {
    //     $horas = intdiv($promedio_min, 60);
    //     $minutos = $promedio_min % 60;
    //     $tiempo_promedio = $minutos > 0 ? "{$horas} h {$minutos} min" : "{$horas} h";
    // } else {
    //     $tiempo_promedio = "≈{$promedio_min} minutos";
    // }
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
    // 3. TICKETS POR MES
    // ==========================================================

    $year = now()->year;

    $inc_por_mes = $incQuery
        ->selectRaw("MONTH(created_at) as mes, COUNT(*) as total")
        ->whereYear('created_at', $year)
        ->groupBy('mes')
        ->pluck('total', 'mes');

    $req_por_mes = $reqQuery
        ->selectRaw("MONTH(created_at) as mes, COUNT(*) as total")
        ->whereYear('created_at', $year)
        ->groupBy('mes')
        ->pluck('total', 'mes');

    $meses = collect(range(1, 12))->map(fn($m) => \Carbon\Carbon::create()->month($m)->format('M'));

    $incidentes = [];
    $requerimientos = [];

    foreach (range(1, 12) as $m) {
        $incidentes[] = $inc_por_mes[$m] ?? 0;
        $requerimientos[] = $req_por_mes[$m] ?? 0;
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
