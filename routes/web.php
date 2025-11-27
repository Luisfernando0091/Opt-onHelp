<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidenteController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RequerimientoController;
use App\Http\Controllers\ActivoController;
use App\Http\Controllers\HistorialActivoController;
Route::get('/', fn() => redirect()->route('login'));

Auth::routes();

// Admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
});

Route::get('/test-email', function () {
    Mail::raw('Correo de prueba desde OpcionHelp 🚀', function ($message) {
        $message->to('tucorreo@option.com.pe')
                ->subject('Prueba de envío desde Laravel');
    });
    return '✅ Correo enviado correctamente.';
});

// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Incidentes CRUD
Route::resource('incidentes', IncidenteController::class);

// EXPORTAR PDF / EXCEL
Route::get('/incidentes/export/pdf', [IncidenteController::class, 'exportPdf'])
    ->name('incidentes.export.pdf');

Route::get('/incidentes/export/excel', [IncidenteController::class, 'exportExcel'])
    ->name('incidentes.export.excel');

// REPORTES
Route::get('/reportes/incidentes', [IncidenteController::class, 'reporte'])
    ->name('reportes.incidentes');

// Requerimientos CRUD
Route::resource('requerimientos', RequerimientoController::class);

Route::put('/usuarios/{id}/cambiar-estado', [App\Http\Controllers\UserController::class, 'cambiarEstado'])
    ->name('usuarios.cambiarEstado');

    // routes/web.php o api.php

Route::post('/activo/{id}/asignar', [ActivoController::class, 'asignar']);
// routes/web.php
Route::get('/activos', [ActivoController::class, 'index']);
Route::post('/activo/{id}/asignar', [ActivoController::class, 'asignar']);
// Route::get('/activo/{id}/historial', [ActivoController::class, 'historial']);
Route::get('/activos/create', [ActivoController::class, 'create'])->name('activos.create');
Route::post('/activos', [ActivoController::class, 'store'])->name('activos.store');
Route::resource('activos', ActivoController::class);
Route::get('activos/{id}/historial', [ActivoController::class, 'historial'])->name('activos.historial');
    Route::get('activos/{id}/historial', [ActivoController::class, 'historial'])
        ->name('activos.historial');
        Route::get('/activos/{activo}/historial/create', [HistorialActivoController::class, 'create'])->name('historial.create');
Route::post('/activos/{activo}/historial', [HistorialActivoController::class, 'store'])->name('historial.store');
// Historial Mantenimiento
Route::get('/activos/{id}/historial/create', [HistorialActivoController::class, 'create'])
    ->name('historial.create');

Route::post('/activos/{id}/historial', [HistorialActivoController::class, 'store'])
    ->name('historial.store');


// Route::prefix('activos')->group(function () {

//     Route::get('/', [ActivoController::class, 'index'])->name('activos.index');

//     Route::get('/create', [ActivoController::class, 'create'])->name('activos.create');
//     Route::post('/store', [ActivoController::class, 'store'])->name('activos.store');

//     Route::post('/{id}/asignar', [ActivoController::class, 'asignar'])->name('activos.asignar');

//     Route::get('/{id}/historial', [ActivoController::class, 'historial'])->name('activos.historial');
// });

// Route::post('/activo/{id}/mantenimiento', [ActivoController::class, 'mantenimiento'])
//     ->name('activos.mantenimiento');
// Route::get('/activo/{id}/historial', [ActivoController::class, 'historialAjax']);
