<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IncidenteApiController;

// TEST
Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando correctamente ✅']);
});

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// INCIDENTES API
Route::middleware('auth:sanctum')->group(function () {

    // listar todos los incidentes del usuario autenticado
    Route::get('/incidentes', [IncidenteApiController::class, 'index']);

    // obtener un incidente
    Route::get('/incidentes/{id}', [IncidenteApiController::class, 'show']);

    // actualizar solución y estado
    Route::put('/incidentes/{id}', [IncidenteApiController::class, 'updateSolucion']);
});
