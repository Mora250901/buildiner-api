<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ConstruccionController;
use App\Http\Controllers\API\InspeccionController;
use App\Http\Controllers\API\DistritoController;
use App\Http\Controllers\API\EvidenciaController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
