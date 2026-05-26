<?php

namespace App\Http\Requests;

class UpdateCategoriaRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'nombre'      => ['sometimes', 'required', 'string', 'max:100'],
            'descripcion' => ['nullable', 'string', 'max:300'],
            'img'         => ['nullable', 'string', 'max:500'],
        ];
    }
}
