<?php

namespace App\Http\Requests;

class StoreEstadoPedidoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'nombre'      => ['required', 'string', 'max:80', 'unique:estado_pedidos,nombre'],
            'descripcion' => ['nullable', 'string', 'max:300'],
            'color'       => ['nullable', 'string', 'max:20'],
            'orden'       => ['nullable', 'integer', 'min:0'],
        ];
    }
}
