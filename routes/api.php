<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController;
use App\Http\Controllers\Api\EstadoPedidoController;
use App\Http\Controllers\Api\MercadoController;
use App\Http\Controllers\Api\PedidoController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\RepartidorController;
use App\Http\Controllers\Api\ResenaRepartidorController;
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
Route::get('/repartidores/{repartidor}/resenas', [ResenaRepartidorController::class, 'porRepartidor']);

// Reseñas de repartidores CRUD
Route::apiResource('resenas-repartidor', ResenaRepartidorController::class);

// Vendedores CRUD + asignacion de mercados
Route::apiResource('vendedores', VendedorController::class);
Route::post('/vendedores/{vendedor}/mercados', [VendedorController::class, 'asignarMercado']);
Route::delete('/vendedores/{vendedor}/mercados/{mercado}', [VendedorController::class, 'desasignarMercado']);

// Mercados CRUD
Route::apiResource('mercados', MercadoController::class);

// Categorias CRUD
Route::apiResource('categorias', CategoriaController::class);

// Estados de pedido CRUD
Route::apiResource('estado-pedidos', EstadoPedidoController::class);

// Productos CRUD
Route::apiResource('productos', ProductoController::class);

// Pedidos CRUD + actualizar estado
Route::apiResource('pedidos', PedidoController::class);
Route::patch('/pedidos/{pedido}/estado', [PedidoController::class, 'actualizarEstado']);
