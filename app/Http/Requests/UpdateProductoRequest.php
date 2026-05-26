<?php

namespace App\Http\Requests;

class UpdateProductoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'categoria_id'  => ['sometimes', 'required', 'integer', 'exists:categorias,id'],
            'mercado_id'    => ['sometimes', 'required', 'integer', 'exists:mercados,id'],
            'nombre'        => ['sometimes', 'required', 'string', 'max:200'],
            'descripcion'   => ['nullable', 'string'],
            'precio'        => ['sometimes', 'required', 'numeric', 'min:0'],
            'stock'         => ['nullable', 'integer', 'min:0'],
            'img_producto'  => ['nullable', 'string', 'max:500'],
            'activo'        => ['nullable', 'boolean'],
        ];
    }
}
