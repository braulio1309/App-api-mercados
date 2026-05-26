<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarEstadoPedidoRequest;
use App\Http\Requests\StorePedidoRequest;
use App\Http\Requests\UpdatePedidoRequest;
use App\Http\Resources\PedidoResource;
use App\Models\HistorialEstadoPedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $pedidos = Pedido::with(['usuario', 'mercado', 'repartidor', 'estadoPedido', 'items.producto'])
            ->latest()
            ->paginate(15);

        return PedidoResource::collection($pedidos);
    }

    public function store(StorePedidoRequest $request): JsonResponse
    {
        $data  = $request->validated();
        $items = $data['items'];
        unset($data['items']);

        $pedido = DB::transaction(function () use ($data, $items) {
            $subtotal = 0;

            $itemsData = collect($items)->map(function ($item) use (&$subtotal) {
                $producto = Producto::findOrFail($item['producto_id']);
                $precioUnitario = $producto->precio;
                $itemSubtotal   = round($precioUnitario * $item['cantidad'], 2);
                $subtotal      += $itemSubtotal;

                return [
                    'producto_id'    => $item['producto_id'],
                    'cantidad'       => $item['cantidad'],
                    'precio_unitario'=> $precioUnitario,
                    'subtotal'       => $itemSubtotal,
                ];
            });

            $descuento   = $data['descuento'] ?? 0;
            $costoEnvio  = $data['costo_envio'] ?? 0;
            $total       = round($subtotal - $descuento + $costoEnvio, 2);

            $pedido = Pedido::create(array_merge($data, [
                'subtotal'   => $subtotal,
                'descuento'  => $descuento,
                'costo_envio'=> $costoEnvio,
                'total'      => $total,
            ]));

            $pedido->items()->createMany($itemsData->toArray());

            HistorialEstadoPedido::create([
                'pedido_id'        => $pedido->id,
                'estado_pedido_id' => $pedido->estado_pedido_id,
                'notas'            => 'Pedido creado.',
            ]);

            return $pedido;
        });

        return response()->json([
            'message' => 'Pedido creado exitosamente.',
            'data'    => new PedidoResource(
                $pedido->load(['usuario', 'mercado', 'repartidor', 'estadoPedido', 'items.producto', 'historialEstados.estadoPedido'])
            ),
        ], 201);
    }

    public function show(Pedido $pedido): PedidoResource
    {
        $pedido->load(['usuario', 'mercado', 'repartidor', 'estadoPedido', 'items.producto', 'historialEstados.estadoPedido']);

        return new PedidoResource($pedido);
    }

    public function update(UpdatePedidoRequest $request, Pedido $pedido): JsonResponse
    {
        $pedido->update($request->validated());

        if ($request->has('descuento') || $request->has('costo_envio')) {
            $total = round($pedido->subtotal - $pedido->descuento + $pedido->costo_envio, 2);
            $pedido->update(['total' => $total]);
        }

        return response()->json([
            'message' => 'Pedido actualizado exitosamente.',
            'data'    => new PedidoResource(
                $pedido->load(['usuario', 'mercado', 'repartidor', 'estadoPedido', 'items.producto', 'historialEstados.estadoPedido'])
            ),
        ]);
    }

    public function destroy(Pedido $pedido): JsonResponse
    {
        $pedido->delete();

        return response()->json([
            'message' => 'Pedido eliminado exitosamente.',
        ]);
    }

    public function actualizarEstado(ActualizarEstadoPedidoRequest $request, Pedido $pedido): JsonResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($data, $pedido) {
            $pedido->update(['estado_pedido_id' => $data['estado_pedido_id']]);

            HistorialEstadoPedido::create([
                'pedido_id'        => $pedido->id,
                'estado_pedido_id' => $data['estado_pedido_id'],
                'notas'            => $data['notas'] ?? null,
            ]);
        });

        return response()->json([
            'message' => 'Estado del pedido actualizado exitosamente.',
            'data'    => new PedidoResource(
                $pedido->load(['usuario', 'mercado', 'repartidor', 'estadoPedido', 'items.producto', 'historialEstados.estadoPedido'])
            ),
        ]);
    }
}
