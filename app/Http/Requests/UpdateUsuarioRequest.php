<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUsuarioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('usuario');

        return [
            'nombres'   => ['sometimes', 'string', 'max:100'],
            'apellidos' => ['sometimes', 'string', 'max:100'],
            'ciudad'    => ['sometimes', 'string', 'max:100'],
            'distrito'  => ['sometimes', 'string', 'max:100'],
            'direccion' => ['sometimes', 'string', 'max:255'],
            'latitud'   => ['nullable', 'numeric', 'between:-90,90'],
            'longitud'  => ['nullable', 'numeric', 'between:-180,180'],
            'celular'   => ['sometimes', 'string', 'max:20'],
            'email'     => ['sometimes', 'email', "unique:users,email,{$userId}"],
            'password'  => ['sometimes', 'string', 'min:8', 'confirmed'],
        ];
    }
}
