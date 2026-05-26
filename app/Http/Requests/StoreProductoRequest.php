<?php

namespace App\Http\Requests;

class StoreProductoRequest extends ApiFormRequest
{
    public function rules(): array
    {
        return [
            'categoria_id'  => ['required', 'integer', 'exists:categorias,id'],
            'mercado_id'    => ['required', 'integer', 'exists:mercados,id'],
            'nombre'        => ['required', 'string', 'max:200'],
            'descripcion'   => ['nullable', 'string'],
            'precio'        => ['required', 'numeric', 'min:0'],
            'stock'         => ['nullable', 'integer', 'min:0'],
            'img_producto'  => ['nullable', 'string', 'max:500'],
            'activo'        => ['nullable', 'boolean'],
        ];
    }
}
