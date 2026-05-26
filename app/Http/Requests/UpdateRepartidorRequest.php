<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRepartidorRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('repartidor');

        return [
            'nombres'        => ['sometimes', 'string', 'max:100'],
            'apellidos'      => ['sometimes', 'string', 'max:100'],
            'ciudad'         => ['sometimes', 'string', 'max:100'],
            'dni_carnet'     => ['sometimes', 'string', 'max:20', "unique:repartidores,dni_carnet,{$id}"],
            'celular'        => ['sometimes', 'string', 'max:20'],
            'email'          => ['sometimes', 'email', "unique:repartidores,email,{$id}"],
            'placa_vehiculo' => ['nullable', 'string', 'max:20'],
            'password'       => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
