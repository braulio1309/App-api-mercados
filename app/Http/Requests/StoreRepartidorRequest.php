<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRepartidorRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres'        => ['required', 'string', 'max:100'],
            'apellidos'      => ['required', 'string', 'max:100'],
            'ciudad'         => ['required', 'string', 'max:100'],
            'dni_carnet'     => ['required', 'string', 'max:20', 'unique:repartidores,dni_carnet'],
            'celular'        => ['required', 'string', 'max:20'],
            'email'          => ['required', 'email', 'unique:repartidores,email'],
            'placa_vehiculo' => ['nullable', 'string', 'max:20'],
            'password'       => ['required', 'string', 'min:8', 'confirmed'],
            'latitud'        => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'       => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }
}
