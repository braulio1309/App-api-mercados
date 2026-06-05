<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResenaRepartidorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'pedido_id'    => $this->pedido_id,
            'usuario'      => new UsuarioResource($this->whenLoaded('usuario')),
            'repartidor'   => new RepartidorResource($this->whenLoaded('repartidor')),
            'calificacion' => $this->calificacion,
            'comentario'   => $this->comentario,
            'creado_en'    => $this->created_at,
        ];
    }
}
