<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MercadoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'nombre_establecimiento' => $this->nombre_establecimiento,
            'numero_local'           => $this->numero_local,
            'img_puesto'             => $this->img_puesto,
            'horario_atencion'       => $this->horario_atencion,
            'nombre_dueno'           => $this->nombre_dueno,
            'ruc'                    => $this->ruc,
            'vendedores'             => VendedorResource::collection($this->whenLoaded('vendedores')),
            'creado_en'              => $this->created_at,
        ];
    }
}
