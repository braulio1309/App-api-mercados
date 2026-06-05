<?php

namespace App\Http\Requests;

class StoreResenaRepartidorRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'pedido_id'      => ['required', 'integer', 'exists:pedidos,id', 'unique:resenas_repartidores,pedido_id'],
            'usuario_id'     => ['required', 'integer', 'exists:users,id'],
            'repartidor_id'  => ['required', 'integer', 'exists:repartidores,id'],
            'calificacion'   => ['required', 'integer', 'between:0,5'],
            'comentario'     => ['nullable', 'string', 'max:1000'],
        ];
    }
}
