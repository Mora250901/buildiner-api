<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConstruccionController;
use App\Http\Controllers\API\InspeccionController;
use App\Http\Controllers\API\DistritoController;
use App\Http\Controllers\API\EvidenciaController;

// ── Auth ──
Route::post('/login',  [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);

    // ── Distritos ──
    Route::apiResource('distritos', DistritoController::class);

    // ── Construcciones ──
    Route::apiResource('construcciones', ConstruccionController::class);

    // ── Inspecciones ──
    Route::apiResource('inspecciones', InspeccionController::class);

    // ── Evidencias ──
    Route::apiResource('evidencias', EvidenciaController::class);
});