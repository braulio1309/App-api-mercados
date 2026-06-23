<?php

namespace App\Http\Requests;

class UpdatePagoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'monto'            => ['sometimes', 'numeric', 'min:0'],
            'metodo_pago'      => ['sometimes', 'string', 'in:efectivo,tarjeta_credito,tarjeta_debito,transferencia,yape,plin,otro'],
            'estado'           => ['sometimes', 'string', 'in:pendiente,completado,fallido,reembolsado'],
            'referencia_pago'  => ['nullable', 'string', 'max:200'],
            'notas'            => ['nullable', 'string'],
            'estado_pedido_id' => ['nullable', 'integer', 'exists:estado_pedidos,id'],
        ];
    }
}
