<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMercadoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre_establecimiento'     => ['sometimes', 'string', 'max:200'],
            'numero_local'               => ['sometimes', 'string', 'max:50'],
            'img_puesto'                 => ['nullable', 'string', 'max:500'],
            'horario_atencion'           => ['nullable', 'array'],
            'horario_atencion.*.dia'     => ['required_with:horario_atencion', 'string'],
            'horario_atencion.*.apertura'=> ['required_with:horario_atencion', 'string'],
            'horario_atencion.*.cierre'  => ['required_with:horario_atencion', 'string'],
            'nombre_dueno'               => ['sometimes', 'string', 'max:200'],
            'ruc'                        => ['nullable', 'string', 'max:11'],
        ];
    }
}
