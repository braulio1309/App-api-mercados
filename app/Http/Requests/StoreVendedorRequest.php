<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendedorRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres'    => ['required', 'string', 'max:100'],
            'apellidos'  => ['required', 'string', 'max:100'],
            'celular'    => ['required', 'string', 'max:20'],
            'dni_carnet' => ['required', 'string', 'max:20', 'unique:vendedores,dni_carnet'],
            'email'      => ['required', 'email', 'unique:vendedores,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
