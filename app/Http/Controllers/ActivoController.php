<?php

namespace App\Http\Controllers;

use App\Models\Activo;
use App\Models\User;
use App\Models\HistorialActivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Ubicacion;
use  App\Models\CategoriaInventario;
class ActivoController extends Controller
{
    //

// Asignar activo (POST /activos/{id}/asignar)
public function asignar(Request $request, $id)
{
    $request->validate([
        // 'user_id' => 'required|exists:users,id',
        'asignado_a' => 'required|exists:users,id',

        'observacion' => 'nullable|string|max:1000',
        
    ]);

    $activo = Activo::findOrFail($id);
    $activo->asignado_a = $request->asignado_a;
    $activo->estado = 'Asignado';
    $activo->save();
    HistorialActivo::create([
        'activo_id' => $activo->id,
        'user_id' => Auth::id() ?? $request->asignado_a,
        'accion' => 'Asignado',
        'observacion' => $request->observacion ?? 'Asignado al usuario ID ' . $request->asignado_a,
    ]);


    // Si llamas por AJAX podrías devolver JSON, aquí redirigimos
    return redirect()->back()->with('success', 'Activo asignado correctamente');
}

// Registrar mantenimiento (POST /activos/{id}/mantenimiento)
// public function mantenimiento(Request $request, $id)
// {
//     $request->validate([
//         'detalle' => 'required|string|max:2000',
//         'estado_final' => 'nullable|string|in:Disponible,Asignado,Mantenimiento',
//     ]);

//     $activo = Activo::findOrFail($id);

//     // Guardar en historial
//     HistorialActivo::create([
//         'activo_id' => $activo->id,
//         'user_id' => Auth::id(),
//         'accion' => 'Mantenimiento',
//         'detalle' => $request->detalle,
//     ]);

//     // Si el técnico envió estado_final lo aplicamos
//     if ($request->filled('estado_final')) {
//         $activo->estado = $request->estado_final;
//         $activo->save();
//     }

//     return redirect()->back()->with('success', 'Mantenimiento registrado correctamente');
// }
    public function mantenimiento(Request $request, $id)
    {
        $request->validate([
            'observacion' => 'required|string|max:2000',
                    'pieza_id' => 'nullable|exists:pieza_mantenimiento,id', // si existe tabla

        ]);

        HistorialActivo::create([
            'activo_id' => $id,
            'user_id' => auth()->id(),
            'accion' => 'Mantenimiento',
            'observacion' => $request->observacion,
                    'pieza_id' => $request->pieza_id, // <-- AQUÍ TAMBIÉN

        ]);

        return back()->with('success', 'Mantenimiento registrado correctamente.');
    }



// Historial para AJAX (GET /activos/{id}/historial)
public function historialAjax($id)
{
    $activo = Activo::with('historial.usuario')->findOrFail($id);
    return view('Activos.historial_ajax', compact('activo'));
}


public function index()
{
    $activos = Activo::with('usuario')->get();
    $usuarios = User::all();
return view('Activos.listactivos', compact('activos', 'usuarios'));
}

public function historial($id)
{
    $activo = Activo::with('historial.usuario')->findOrFail($id);
    return view('Activos.historial', compact('activo'));
}
public function edit($id)
{
    $activo = Activo::findOrFail($id);
    $usuarios = User::all();
    $ubicaciones = Ubicacion::all();

    return view('Activos.edit', compact('activo', 'usuarios', 'ubicaciones'));
}



// Mostrar formulario para crear un activo
public function create()
{
    $usuarios = User::all(); // si quieres asignar un usuario al activo
        $ubicaciones = Ubicacion::all();
        $categorias_inventario = CategoriaInventario::all();

    return view('Activos.create', compact('usuarios', 'ubicaciones','categorias_inventario'));
    
}

// Guardar activo
public function store(Request $request)
{
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'tipo' => 'required|string|max:255',
        'marca' => 'nullable|string|max:255',
        'modelo' => 'nullable|string|max:255',
        'serial' => 'required|string|max:255',
        // 'categoria' => 'nullable|string|max:255',
        'caracteristica' => 'nullable|string|max:255',
        'descripcion' => 'nullable|string',
        'estado' => 'required|in:Disponible,Asignado,Mantenimiento',
        'asignado_a' => 'nullable|exists:users,id',
        'ubicacion_id' => 'required|exists:ubicaciones,id',
        'categoria' => 'required|exists:categoria_inventario,id',

        //'categoria_id'  => 'request->categoria_id', 

    ]);

    Activo::create($data);

    return redirect()->route('activos.index')->with('success', 'Activo creado correctamente');
}

// public function mantenimiento(Request $request, $id)
// {
//     $request->validate([
//         'detalle' => 'required|string|max:255',
//     ]);

//     HistorialActivo::create([
//         'activo_id' => $id,
//         'user_id' => Auth::id(), // quién realizó el mantenimiento
//         'accion' => 'mantenimiento',
//         'detalle' => $request->detalle,
//     ]);

//     return redirect()->route('activos.index')
//         ->with('success', 'Mantenimiento registrado correctamente');
// }


//     public function historialAjax($id)
// {
//     $activo = Activo::with('historial.usuario')->findOrFail($id);

//     return view('Activos.historial_ajax', compact('activo'));
// }
    public function update(Request $request, $id)
    {
        $activo = Activo::findOrFail($id);

        $estadoAnterior = $activo->estado;

        $activo->update($request->all());

        if ($estadoAnterior !== $activo->estado) {
            HistorialActivo::create([
                'activo_id' => $activo->id,
                'user_id' => auth()->id(),
                'accion' => 'Cambio de estado',
                'observacion' => "Estado: de '$estadoAnterior' a '{$activo->estado}'",
                'ubicacion_id' => 'required|exists:ubicaciones,id'

            ]);
        }

        return back()->with('success', 'Activo actualizado y registrado en historial.');
    }

    public function show($id)
{
    $activo = Activo::with('historial.usuario')->findOrFail($id);
    return view('Activos.show', compact('activo'));
}
//FUNCIION PARA LA VISTA DE ACTIVOSWIES


public function activosWies(Request $request)
{
    // Consulta base con relaciones
    $query = Activo::with(['categoriaInventario', 'ubicacion', 'usuario']);

    // Filtro por Categoría
    if ($request->filled('categoria_id')) {
        $query->where('categoria', $request->categoria_id);
    }

    // Filtro por Ubicación
    if ($request->filled('ubicacion_id')) {
        $query->where('ubicacion_id', $request->ubicacion_id);
    }

    $activos = $query->get();
    $usuarios = User::all();

    // Para llenar el select de filtros
    $categorias = \App\Models\CategoriaInventario::all();
    $ubicaciones = \App\Models\Ubicacion::all();

    return view('Activos.activoswies', compact('activos', 'usuarios', 'categorias', 'ubicaciones'));
}


}
