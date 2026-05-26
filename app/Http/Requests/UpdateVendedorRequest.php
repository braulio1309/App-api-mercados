<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendedorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('vendedor');

        return [
            'nombres'    => ['sometimes', 'string', 'max:100'],
            'apellidos'  => ['sometimes', 'string', 'max:100'],
            'celular'    => ['sometimes', 'string', 'max:20'],
            'dni_carnet' => ['sometimes', 'string', 'max:20', "unique:vendedores,dni_carnet,{$id}"],
            'email'      => ['sometimes', 'email', "unique:vendedores,email,{$id}"],
            'password'   => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
