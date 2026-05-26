<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'nombre'      => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio'      => $this->precio,
            'stock'       => $this->stock,
            'img_producto'=> $this->img_producto,
            'activo'      => $this->activo,
            'categoria'   => new CategoriaResource($this->whenLoaded('categoria')),
            'mercado'     => new MercadoResource($this->whenLoaded('mercado')),
            'creado_en'   => $this->created_at,
        ];
    }
}
