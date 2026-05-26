<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateEstadoPedidoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'nombre'      => ['sometimes', 'required', 'string', 'max:80', Rule::unique('estado_pedidos', 'nombre')->ignore($this->route('estado_pedido'))],
            'descripcion' => ['nullable', 'string', 'max:300'],
            'color'       => ['nullable', 'string', 'max:20'],
            'orden'       => ['nullable', 'integer', 'min:0'],
        ];
    }
}
