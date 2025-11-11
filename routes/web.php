<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidenteController;
use Illuminate\Support\Facades\Mail;

Route::get('/', fn() => redirect()->route('login'));

Auth::routes();

// Solo accesible por admin
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
// });
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
    
});


Route::get('/test-email', function () {
    Mail::raw('Correo de prueba desde OpcionHelp 🚀', function ($message) {
        $message->to('tucorreo@option.com.pe') // 👈 aquí va tu correo real
                ->subject('Prueba de envío desde Laravel');
    });
    return '✅ Correo enviado correctamente. Revisa Mailtrap.';
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('incidentes', IncidenteController::class);
//EXPORTAR

Route::get('/incidentes/export/pdf', [IncidenteController::class, 'exportPDF'])
    ->name('incidentes.export.pdf');

Route::get('/incidentes/export/excel', [IncidenteController::class, 'exportExcel'])
    ->name('incidentes.export.excel');



Route::get('/reportes/incidentes', [App\Http\Controllers\IncidenteController::class, 'reporte'])
     ->name('reportes.incidentes');

Route::get('/incidentes/export/pdf', [IncidenteController::class, 'exportPdf'])->name('incidentes.export.pdf');
Route::get('/incidentes/export/excel', [IncidenteController::class, 'exportExcel'])->name('incidentes.export.excel');
Route::get('/reportes/incidentes', [IncidenteController::class, 'reporte'])->name('reportes.incidentes');
