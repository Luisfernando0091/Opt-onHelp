<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Contar tickets por estado
        $pendientes = Incidente::where('estado', 'pendiente')->count();
        $en_proceso = Incidente::where('estado', 'en proceso')->count();
        $cerrados = Incidente::where('estado', 'cerrado')->count();

        // Retornar a la vista con los datos
        return view('home', compact('pendientes', 'en_proceso', 'cerrados'));
    }
}
