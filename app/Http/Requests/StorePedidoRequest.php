<?php

namespace App\Http\Requests;

class StorePedidoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'usuario_id'        => ['required', 'integer', 'exists:users,id'],
            'mercado_id'        => ['required', 'integer', 'exists:mercados,id'],
            'repartidor_id'     => ['nullable', 'integer', 'exists:repartidores,id'],
            'estado_pedido_id'  => ['required', 'integer', 'exists:estado_pedidos,id'],
            'direccion_entrega' => ['required', 'string', 'max:400'],
            'referencia'        => ['nullable', 'string', 'max:300'],
            'latitud'           => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'          => ['nullable', 'numeric', 'between:-180,180'],
            'notas'             => ['nullable', 'string'],
            'descuento'         => ['nullable', 'numeric', 'min:0'],
            'costo_envio'       => ['nullable', 'numeric', 'min:0'],
            'items'             => ['required', 'array', 'min:1'],
            'items.*.producto_id'   => ['required', 'integer', 'exists:productos,id'],
            'items.*.cantidad'      => ['required', 'integer', 'min:1'],
        ];
    }
}
