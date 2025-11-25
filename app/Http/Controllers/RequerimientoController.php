<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requerimiento;
use App\Models\BssCreque; // ✅ tabla con los casos de requerimientos
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\RequerimientoRegistradoMail;
use Illuminate\Support\Facades\Log;

class RequerimientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 📋 Mostrar lista de requerimientos
     */
public function index(Request $request)
{
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        $requerimientos = Requerimiento::with(['usuario', 'tecnico'])
            ->orderByDesc('id')
            ->get();
    } elseif ($user->hasRole('tecnico')) {
        $requerimientos = Requerimiento::with(['usuario', 'tecnico'])
            ->where('tecnico_id', $user->id)
            ->orderByDesc('id')
            ->get();
    } elseif ($user->hasRole('usuario')) {
        $requerimientos = Requerimiento::with(['usuario', 'tecnico'])
            ->where('usuario_id', $user->id)
            ->orderByDesc('id')
            ->get();
    } else {
        $requerimientos = collect();
    }

    // 🔹 Si es una solicitud AJAX (solo recarga la tabla)
    if ($request->ajax()) {
        return view('requerimientos.partials.listar', compact('requerimientos'))->render();
    }

    // 🔹 Si es una vista completa (primera carga)
    
    return view('requerimientos.index', compact('requerimientos'));
}


    /**
     * ➕ Mostrar formulario de creación
     */
    public function create()
    {
        // Tipos de requerimiento (tabla bss_creque)
        $tiposRequerimientos = BssCreque::all();

        // Técnicos activos con rol "tecnico"
        $tecnicos = User::role('tecnico')
            ->where('activo', 1)
            ->get();

        // Generar nuevo código
        $ultimo = Requerimiento::orderBy('id', 'desc')->count();
        $nuevoCodigo = 'REQ-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

        return view('requerimientos.create', compact('tiposRequerimientos', 'tecnicos', 'nuevoCodigo'));
    }

    /**
     * 💾 Guardar nuevo requerimiento
     */
//     public function store(Request $request)
// {
//     $request->validate([
//         'codigo' => 'required|exists:bss_creque,CODIGO',
//         'descripcion' => 'required|string',
//         'prioridad' => 'required|in:Alta,Media,Baja',
//         'tecnico_id' => 'required|exists:users,id',
//         'fecha_reporte' => 'required|date',
//     ]);

//     // Buscar tipo de requerimiento
//     $tipo = BssCreque::where('CODIGO', $request->codigo)->first();

//     // Crear requerimiento
//     $requerimiento = new Requerimiento();
//     $requerimiento->usuario_id = Auth::id();

//     // Código incremental
//     $ultimo = Requerimiento::orderBy('id', 'desc')->count();
//     $nuevoCodigo = 'REQ-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

//     $requerimiento->codigo = $nuevoCodigo;
//     $requerimiento->titulo = $tipo->nombre_caso;
//     $requerimiento->descripcion = $request->descripcion;
//     $requerimiento->estado = 'Pendiente';
//     $requerimiento->prioridad = $request->prioridad;
//     $requerimiento->tecnico_id = $request->tecnico_id;
//     $requerimiento->fecha_reporte = $request->fecha_reporte;
//     $requerimiento->save();

//     // 📨 ENVIAR CORREO AL USUARIO
//     Mail::to($requerimiento->usuario->email)
//         ->send(new RequerimientoRegistradoMail($requerimiento));

//     return redirect()
//         ->route('requerimientos.index')
//         ->with('success', '✅ Requerimiento registrado correctamente.');
// }



public function store(Request $request)
{
    $request->validate([
        'codigo' => 'required|exists:bss_creque,CODIGO',
        'descripcion' => 'required|string',
        'prioridad' => 'required|in:Alta,Media,Baja',
        'tecnico_id' => 'required|exists:users,id',
        'fecha_reporte' => 'required|date',
    ]);

    // Buscar tipo de requerimiento
    $tipo = BssCreque::where('CODIGO', $request->codigo)->first();

    // Crear requerimiento
    $requerimiento = new Requerimiento();
    $requerimiento->usuario_id = Auth::id();

    // Código incremental
    $ultimo = Requerimiento::orderBy('id', 'desc')->count();
    $nuevoCodigo = 'REQ-' . str_pad($ultimo + 1, 4, '0', STR_PAD_LEFT);

    $requerimiento->codigo = $nuevoCodigo;
    $requerimiento->titulo = $tipo->nombre_caso;
    $requerimiento->descripcion = $request->descripcion;
    $requerimiento->estado = 'Pendiente';
    $requerimiento->prioridad = $request->prioridad;
    $requerimiento->tecnico_id = $request->tecnico_id;
    $requerimiento->fecha_reporte = $request->fecha_reporte;
    $requerimiento->save();

    // 📨 ENVIAR CORREO AL USUARIO
    Mail::to($requerimiento->usuario->email)
        ->send(new RequerimientoRegistradoMail($requerimiento));

    // 🚀 **ENVIAR NOTIFICACIÓN PUSH AL TÉCNICO**
    try {
    $firebase = app(\App\Services\FirebaseMessagingService::class);

    // Obtener token más reciente del técnico
    $userToken = \App\Models\UserToken::where('user_id', $request->tecnico_id)
        ->orderByDesc('created_at')
        ->first();

    $reportante = auth()->user()->name;
    $lastname   = auth()->user()->LastName ?? '';
    $nombreCompleto = $reportante . ' ' . $lastname;

    if ($userToken && $userToken->token) {
        $firebase->sendToToken(
            $userToken->token,
            "Nuevo Requerimiento Asignado",
            "Código: {$requerimiento->codigo} - {$requerimiento->titulo} | Reportado por: {$nombreCompleto}",
            [
                "requerimiento_id" => $requerimiento->id,
                "codigo" => $requerimiento->codigo,
                "reportado_por" => $nombreCompleto
            ]
        );
    } else {
        \Log::warning("⚠️ No se encontró token FCM para el técnico ID {$request->tecnico_id}");
    }

} catch (\Throwable $e) {
    \Log::error("🔥 Error al enviar notificación FCM: " . $e->getMessage());
}


    return redirect()
        ->route('requerimientos.index')
        ->with('success', '✅ Requerimiento registrado correctamente.');
}

    public function show($id)
    {
        $requerimiento = Requerimiento::with(['usuario', 'tecnico'])->findOrFail($id);
        return view('requerimientos.show', compact('requerimiento'));
    }

    /**
     * ✏️ Editar
     */
    public function edit($id)
    {
        $requerimiento = Requerimiento::findOrFail($id);
        $tecnicos = User::role('tecnico')->where('activo', 1)->get();
        return view('requerimientos.edit', compact('requerimiento', 'tecnicos'));
    }

    /**
     * 🔁 Actualizar
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:Pendiente,En proceso,A la espera,Finalizado',
            'prioridad' => 'required|in:Baja,Media,Alta,Crítica',
            'tecnico_id' => 'nullable|exists:users,id',
            'solucion' => 'nullable|string',
        ]);

        $requerimiento = Requerimiento::findOrFail($id);

        if ($validated['estado'] === 'Finalizado') {
            $validated['fecha_cierre'] = now();
        } else {
            $validated['fecha_cierre'] = null;
        }

        $requerimiento->update($validated);

        return redirect()
            ->route('requerimientos.index')
            ->with('success', '✅ Requerimiento actualizado correctamente.');
    }

    /**
     * 🗑️ Eliminar
     */
    public function destroy($id)
    {
        $requerimiento = Requerimiento::findOrFail($id);
        $requerimiento->delete();

        return redirect()
            ->route('requerimientos.index')
            ->with('success', '🗑️ Requerimiento eliminado correctamente.');
    }
}
