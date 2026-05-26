<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEstadoPedidoRequest;
use App\Http\Requests\UpdateEstadoPedidoRequest;
use App\Http\Resources\EstadoPedidoResource;
use App\Models\EstadoPedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EstadoPedidoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $estados = EstadoPedido::orderBy('orden')->get();

        return EstadoPedidoResource::collection($estados);
    }

    public function store(StoreEstadoPedidoRequest $request): JsonResponse
    {
        $estado = EstadoPedido::create($request->validated());

        return response()->json([
            'message' => 'Estado de pedido creado exitosamente.',
            'data'    => new EstadoPedidoResource($estado),
        ], 201);
    }

    public function show(EstadoPedido $estadoPedido): EstadoPedidoResource
    {
        return new EstadoPedidoResource($estadoPedido);
    }

    public function update(UpdateEstadoPedidoRequest $request, EstadoPedido $estadoPedido): JsonResponse
    {
        $estadoPedido->update($request->validated());

        return response()->json([
            'message' => 'Estado de pedido actualizado exitosamente.',
            'data'    => new EstadoPedidoResource($estadoPedido),
        ]);
    }

    public function destroy(EstadoPedido $estadoPedido): JsonResponse
    {
        $estadoPedido->delete();

        return response()->json([
            'message' => 'Estado de pedido eliminado exitosamente.',
        ]);
    }
}
