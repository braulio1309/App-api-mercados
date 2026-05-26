<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendedorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'nombres'    => $this->nombres,
            'apellidos'  => $this->apellidos,
            'celular'    => $this->celular,
            'dni_carnet' => $this->dni_carnet,
            'email'      => $this->email,
            'mercados'   => $this->whenLoaded('mercados', fn () => $this->mercados->map(fn ($m) => [
                'id'                     => $m->id,
                'nombre_establecimiento' => $m->nombre_establecimiento,
                'numero_local'           => $m->numero_local,
                'numero_puesto'          => $m->pivot->numero_puesto,
                'dni_vendedor'           => $m->pivot->dni_vendedor,
            ])),
            'creado_en'  => $this->created_at,
        ];
    }
}
