<?php

namespace App\Http\Requests;

class StorePagoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'pedido_id'        => ['required', 'integer', 'exists:pedidos,id'],
            'monto'            => ['required', 'numeric', 'min:0'],
            'metodo_pago'      => ['required', 'string', 'in:efectivo,tarjeta_credito,tarjeta_debito,transferencia,yape,plin,otro'],
            'estado'           => ['nullable', 'string', 'in:pendiente,completado,fallido,reembolsado'],
            'referencia_pago'  => ['nullable', 'string', 'max:200'],
            'notas'            => ['nullable', 'string'],
            'estado_pedido_id' => ['nullable', 'integer', 'exists:estado_pedidos,id'],
        ];
    }
}
