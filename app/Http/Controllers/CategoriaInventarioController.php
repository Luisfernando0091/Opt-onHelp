<?php

namespace App\Http\Controllers;
use App\Models\CategoriaInventario;

use Illuminate\Http\Request;

class CategoriaInventarioController extends Controller
{
    //Obtener todos las categorias de tabla categoria_inventario
    public function index(){
         $categorias_inventario = CategoriaInventario::all();
        return view('inventario.create', compact('categorias'));
    }

}
