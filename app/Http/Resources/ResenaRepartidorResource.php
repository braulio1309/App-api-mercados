<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ResenaRepartidorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'repartidor'    => new RepartidorResource($this->whenLoaded('repartidor')),
            'usuario'       => new UsuarioResource($this->whenLoaded('usuario')),
            'calificacion'  => $this->calificacion,
            'comentario'    => $this->comentario,
            'creado_en'     => $this->created_at,
            'actualizado_en'=> $this->updated_at,
        ];
    }
}
