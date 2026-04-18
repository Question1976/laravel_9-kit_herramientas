<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EjemploController;
use App\Http\Controllers\ApiCategoriasController;
use App\Http\Controllers\ApiProductosController;
use App\Http\Controllers\ApiProductosFotosController;
use App\Http\Controllers\ApiAccesoController;


/**
 * Rutas API
 */
// === CATEGORÍAS ===
Route::resource('v1/categorias', ApiCategoriasController::class);

// === PRODUCTOS ===
Route::resource('v1/productos', ApiProductosController::class);

// === FOTOS DE PRODUCTOS ===
Route::resource('v1/productos-fotos', ApiProductosFotosController::class);

// === AUTENTICACIÓN ===
Route::resource('v1/login', ApiAccesoController::class);






// =============================================================================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('v1/ejemplo', EjemploController::class);











