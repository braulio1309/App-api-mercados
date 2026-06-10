<?php

namespace App\Http\Requests;

class StoreResenaRepartidorRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'repartidor_id' => ['required', 'integer', 'exists:repartidores,id'],
            'usuario_id'    => ['required', 'integer', 'exists:users,id'],
            'calificacion'  => ['required', 'integer', 'between:1,5'],
            'comentario'    => ['nullable', 'string', 'max:1000'],
        ];
    }
}
