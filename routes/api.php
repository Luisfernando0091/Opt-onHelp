<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IncidenteApiController;
use App\Http\Controllers\UserTokenController;

// TEST
Route::get('/ping', function () {
    return response()->json(['message' => 'API funcionando ✅']);
});

// AUTH
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

// USER TOKENS (FCM)
Route::middleware('auth:sanctum')->post('/save-token', [UserTokenController::class, 'store']);

// INCIDENTES
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/incidentes', [IncidenteApiController::class, 'index']);
    Route::get('/incidentes/{id}', [IncidenteApiController::class, 'show']);
    Route::post('/incidentes', [IncidenteApiController::class, 'store']);
    Route::put('/incidentes/{id}', [IncidenteApiController::class, 'updateSolucion']);
});
