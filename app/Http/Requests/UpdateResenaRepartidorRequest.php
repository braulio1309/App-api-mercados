<?php

namespace App\Http\Requests;

class UpdateResenaRepartidorRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'calificacion' => ['sometimes', 'integer', 'between:1,5'],
            'comentario'   => ['nullable', 'string', 'max:1000'],
        ];
    }
}
