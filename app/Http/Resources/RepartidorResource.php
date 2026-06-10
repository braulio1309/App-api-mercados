<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepartidorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                    => $this->id,
            'nombres'               => $this->nombres,
            'apellidos'             => $this->apellidos,
            'ciudad'                => $this->ciudad,
            'dni_carnet'            => $this->dni_carnet,
            'celular'               => $this->celular,
            'email'                 => $this->email,
            'placa_vehiculo'        => $this->placa_vehiculo,
            'promedio_calificacion' => $this->promedio_calificacion,
            'total_resenas'         => $this->resenas()->count(),
            'creado_en'             => $this->created_at,
        ];
    }
}
