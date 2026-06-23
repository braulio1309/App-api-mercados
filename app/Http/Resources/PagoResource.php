<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'pedido'          => new PedidoResource($this->whenLoaded('pedido')),
            'monto'           => $this->monto,
            'metodo_pago'     => $this->metodo_pago,
            'estado'          => $this->estado,
            'referencia_pago' => $this->referencia_pago,
            'notas'           => $this->notas,
            'historial_pagos' => $this->whenLoaded('historialPagos', fn () =>
                $this->historialPagos->map(fn ($h) => [
                    'id'            => $h->id,
                    'estado'        => $h->estado,
                    'notas'         => $h->notas,
                    'registrado_en' => $h->created_at,
                ])
            ),
            'creado_en'       => $this->created_at,
            'actualizado_en'  => $this->updated_at,
        ];
    }
}
