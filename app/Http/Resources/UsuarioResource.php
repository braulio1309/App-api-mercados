<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UsuarioResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'nombres'   => $this->nombres,
            'apellidos' => $this->apellidos,
            'ciudad'    => $this->ciudad,
            'distrito'  => $this->distrito,
            'direccion' => $this->direccion,
            'latitud'   => $this->latitud,
            'longitud'  => $this->longitud,
            'celular'   => $this->celular,
            'email'     => $this->email,
            'creado_en' => $this->created_at,
        ];
    }
}
