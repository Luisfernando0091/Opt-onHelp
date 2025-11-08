<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\IncidenteController;

Route::get('/', fn() => redirect()->route('login'));

Auth::routes();

// Solo accesible por admin
// Route::middleware(['auth', 'role:admin'])->group(function () {
//     Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
// });
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('usuarios', UserController::class);
});



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('incidentes', IncidenteController::class);
