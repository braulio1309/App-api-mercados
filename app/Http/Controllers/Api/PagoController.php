<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePagoRequest;
use App\Http\Requests\UpdatePagoRequest;
use App\Http\Resources\PagoResource;
use App\Models\HistorialEstadoPedido;
use App\Models\HistorialPago;
use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class PagoController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $pagos = Pago::with(['pedido', 'historialPagos'])
            ->latest()
            ->paginate(15);

        return PagoResource::collection($pagos);
    }

    public function store(StorePagoRequest $request): JsonResponse
    {
        $data = $request->validated();
        $estadoPedidoId = $data['estado_pedido_id'] ?? null;
        unset($data['estado_pedido_id']);

        $estado = $data['estado'] ?? 'pendiente';
        $data['estado'] = $estado;

        $pago = DB::transaction(function () use ($data, $estadoPedidoId, $estado) {
            $pago = Pago::create($data);

            HistorialPago::create([
                'pago_id' => $pago->id,
                'estado'  => $pago->estado,
                'notas'   => 'Pago registrado.',
            ]);

            if ($estadoPedidoId) {
                $pedido = Pedido::findOrFail($pago->pedido_id);
                $pedido->update(['estado_pedido_id' => $estadoPedidoId]);

                HistorialEstadoPedido::create([
                    'pedido_id'        => $pedido->id,
                    'estado_pedido_id' => $estadoPedidoId,
                    'notas'            => 'Estado actualizado al registrar pago.',
                ]);
            }

            return $pago;
        });

        return response()->json([
            'message' => 'Pago registrado exitosamente.',
            'data'    => new PagoResource(
                $pago->load(['pedido', 'historialPagos'])
            ),
        ], 201);
    }

    public function show(Pago $pago): PagoResource
    {
        $pago->load(['pedido', 'historialPagos']);

        return new PagoResource($pago);
    }

    public function update(UpdatePagoRequest $request, Pago $pago): JsonResponse
    {
        $data = $request->validated();
        $estadoPedidoId = $data['estado_pedido_id'] ?? null;
        unset($data['estado_pedido_id']);

        DB::transaction(function () use ($data, $estadoPedidoId, $pago) {
            $estadoAnterior = $pago->estado;
            $pago->update($data);

            if (isset($data['estado']) && $data['estado'] !== $estadoAnterior) {
                HistorialPago::create([
                    'pago_id' => $pago->id,
                    'estado'  => $pago->estado,
                    'notas'   => 'Estado del pago actualizado.',
                ]);
            }

            if ($estadoPedidoId) {
                $pedido = Pedido::findOrFail($pago->pedido_id);
                $pedido->update(['estado_pedido_id' => $estadoPedidoId]);

                HistorialEstadoPedido::create([
                    'pedido_id'        => $pedido->id,
                    'estado_pedido_id' => $estadoPedidoId,
                    'notas'            => 'Estado actualizado al modificar pago.',
                ]);
            }
        });

        return response()->json([
            'message' => 'Pago actualizado exitosamente.',
            'data'    => new PagoResource(
                $pago->load(['pedido', 'historialPagos'])
            ),
        ]);
    }

    public function destroy(Pago $pago): JsonResponse
    {
        $pago->delete();

        return response()->json([
            'message' => 'Pago eliminado exitosamente.',
        ]);
    }

    public function porPedido(Pedido $pedido): AnonymousResourceCollection
    {
        $pagos = $pedido->pagos()
            ->with('historialPagos')
            ->latest()
            ->paginate(15);

        return PagoResource::collection($pagos);
    }
}
