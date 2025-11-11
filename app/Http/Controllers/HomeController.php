<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Contadores por estado (ajusta mayúsculas/minúsculas según tu DB)
        $pendientes = Incidente::where('estado', 'Pendiente')->count();
        $en_proceso = Incidente::where('estado', 'En proceso')->count();
        $cerrados = Incidente::whereIn('estado', ['Cerrado', 'Finalizado'])->count();

        // Obtener solo los tickets que tienen fecha_cierre
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

        // Promedio en minutos (float)
        $promedio_minutos = $total_casos_cerrados > 0 ? ($tiempo_total_minutos / $total_casos_cerrados) : 0;

        // Redondear a minutos enteros para presentación
        $promedio_minutos_round = (int) round($promedio_minutos);

        // Formatear legible:
        if ($promedio_minutos_round >= 60) {
            $horas = intdiv($promedio_minutos_round, 60);
            $minutos = $promedio_minutos_round % 60;
            if ($minutos > 0) {
                $tiempo_promedio = "{$horas} h {$minutos} min";
            } else {
                $tiempo_promedio = "{$horas} h";
            }
        } else {
            // Mostrar aproximación en minutos, ej: "≈21 minutos"
            $tiempo_promedio = "≈{$promedio_minutos_round} minutos";
        }

        return view('home', compact(
            'pendientes',
            'en_proceso',
            'cerrados',
            'tiempo_promedio'
        ));
    }
}
