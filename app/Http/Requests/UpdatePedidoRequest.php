<?php

namespace App\Http\Requests;

class UpdatePedidoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'repartidor_id'     => ['nullable', 'integer', 'exists:repartidores,id'],
            'direccion_entrega' => ['sometimes', 'required', 'string', 'max:400'],
            'referencia'        => ['nullable', 'string', 'max:300'],
            'latitud'           => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'          => ['nullable', 'numeric', 'between:-180,180'],
            'notas'             => ['nullable', 'string'],
            'descuento'         => ['nullable', 'numeric', 'min:0'],
            'costo_envio'       => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
