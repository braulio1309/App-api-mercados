<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AsignarMercadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'mercado_id'    => ['required', 'integer', 'exists:mercados,id'],
            'numero_puesto' => ['required', 'string', 'max:50'],
            'dni_vendedor'  => ['nullable', 'string', 'max:20'],
        ];
    }
}
