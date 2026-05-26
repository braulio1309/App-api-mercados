<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MercadoController;
use App\Http\Controllers\Api\RepartidorController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\VendedorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| All routes here are prefixed with /api automatically.
|
*/

// Auth routes (public)
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

// Protected auth routes
Route::middleware('auth:sanctum')->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

// Usuarios CRUD
Route::apiResource('usuarios', UsuarioController::class);

// Repartidores CRUD
Route::apiResource('repartidores', RepartidorController::class);

// Vendedores CRUD + asignacion de mercados
Route::apiResource('vendedores', VendedorController::class);
Route::post('/vendedores/{vendedor}/mercados', [VendedorController::class, 'asignarMercado']);
Route::delete('/vendedores/{vendedor}/mercados/{mercado}', [VendedorController::class, 'desasignarMercado']);

// Mercados CRUD
Route::apiResource('mercados', MercadoController::class);
