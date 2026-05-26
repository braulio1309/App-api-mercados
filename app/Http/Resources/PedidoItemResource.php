<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PedidoItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'producto'        => new ProductoResource($this->whenLoaded('producto')),
            'cantidad'        => $this->cantidad,
            'precio_unitario' => $this->precio_unitario,
            'subtotal'        => $this->subtotal,
        ];
    }
}
