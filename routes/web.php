<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidenteController;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\RequerimientoController;

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
