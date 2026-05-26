<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'usuario'           => new UsuarioResource($this->whenLoaded('usuario')),
            'mercado'           => new MercadoResource($this->whenLoaded('mercado')),
            'repartidor'        => new RepartidorResource($this->whenLoaded('repartidor')),
            'estado_pedido'     => new EstadoPedidoResource($this->whenLoaded('estadoPedido')),
            'direccion_entrega' => $this->direccion_entrega,
            'referencia'        => $this->referencia,
            'latitud'           => $this->latitud,
            'longitud'          => $this->longitud,
            'notas'             => $this->notas,
            'subtotal'          => $this->subtotal,
            'descuento'         => $this->descuento,
            'costo_envio'       => $this->costo_envio,
            'total'             => $this->total,
            'items'             => PedidoItemResource::collection($this->whenLoaded('items')),
            'historial_estados' => $this->whenLoaded('historialEstados', fn () =>
                $this->historialEstados->map(fn ($h) => [
                    'id'            => $h->id,
                    'estado'        => new EstadoPedidoResource($h->estadoPedido),
                    'notas'         => $h->notas,
                    'registrado_en' => $h->created_at,
                ])
            ),
            'creado_en'         => $this->created_at,
            'actualizado_en'    => $this->updated_at,
        ];
    }
}
