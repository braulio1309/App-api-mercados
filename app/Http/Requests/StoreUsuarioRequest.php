<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres'   => ['required', 'string', 'max:100'],
            'apellidos' => ['required', 'string', 'max:100'],
            'ciudad'    => ['required', 'string', 'max:100'],
            'distrito'  => ['required', 'string', 'max:100'],
            'direccion' => ['required', 'string', 'max:255'],
            'latitud'   => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'  => ['nullable', 'numeric', 'between:-180,180'],
            'celular'   => ['required', 'string', 'max:20'],
            'email'     => ['required', 'email', 'unique:users,email'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
