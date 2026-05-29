<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConstruccionController;
use App\Http\Controllers\API\InspeccionController;
use App\Http\Controllers\API\DistritoController;
use App\Http\Controllers\API\EvidenciaController;
use App\Http\Controllers\API\UsuarioController;
use App\Http\Controllers\API\SuscripcionController;

// ── Auth ──
Route::post('/login',  [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me',      [AuthController::class, 'me']);
    Route::get('usuarios', [UsuarioController::class, 'index']);

    // ── Suscripciones ──
    Route::get('suscripciones',                [SuscripcionController::class, 'index']);
    Route::post('suscripciones',               [SuscripcionController::class, 'store']);
    Route::get('suscripciones/{id}',           [SuscripcionController::class, 'show']);
    Route::patch('suscripciones/{id}/cancelar',[SuscripcionController::class, 'cancelar']);
    Route::get('mi-suscripcion',               [SuscripcionController::class, 'miSuscripcion']);

    // ── Metricas ──
    Route::get('dashboard/metricas', [App\Http\Controllers\API\DashboardController::class, 'metricas']);

    // ── Distritos ──
    Route::apiResource('distritos', DistritoController::class);

    // ── Construcciones ──
    Route::apiResource('construcciones', ConstruccionController::class);

    // ── Inspecciones ──
    Route::apiResource('inspecciones', InspeccionController::class);

    // ── Evidencias ──
    Route::apiResource('evidencias', EvidenciaController::class);
});