<?php

namespace App\Http\Requests;

class ActualizarEstadoPedidoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'estado_pedido_id' => ['required', 'integer', 'exists:estado_pedidos,id'],
            'notas'            => ['nullable', 'string'],
        ];
    }
}
