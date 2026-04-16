<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EjemploController;
use App\Http\Controllers\ApiCategoriasController;


/**
 * Rutas API
 */
// === CATEGORÍAS ===
Route::resource('v1/categorias', ApiCategoriasController::class);


// === PRODUCTOS ===




// =============================================================================
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('v1/ejemplo', EjemploController::class);











