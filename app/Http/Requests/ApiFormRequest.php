<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class ApiFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'required' => 'El campo :attribute es obligatorio.',
            'string' => 'El campo :attribute debe ser una cadena de texto.',
            'email' => 'El campo :attribute debe ser un correo electronico valido.',
            'integer' => 'El campo :attribute debe ser un numero entero.',
            'numeric' => 'El campo :attribute debe ser numerico.',
            'array' => 'El campo :attribute debe ser un arreglo.',
            'min' => 'El campo :attribute debe tener al menos :min caracteres.',
            'max' => 'El campo :attribute no debe superar :max caracteres.',
            'between' => 'El campo :attribute debe estar entre :min y :max.',
            'confirmed' => 'La confirmacion de :attribute no coincide.',
            'unique' => 'El campo :attribute ya se encuentra registrado.',
            'exists' => 'El :attribute seleccionado no existe.',
            'in' => 'El campo :attribute contiene un valor no permitido.',
            'required_with' => 'El campo :attribute es obligatorio cuando :values esta presente.',
        ];
    }

    public function attributes(): array
    {
        return [
            'nombres' => 'nombres',
            'apellidos' => 'apellidos',
            'ciudad' => 'ciudad',
            'distrito' => 'distrito',
            'direccion' => 'direccion',
            'latitud' => 'latitud',
            'longitud' => 'longitud',
            'celular' => 'celular',
            'email' => 'correo electronico',
            'password' => 'contrasena',
            'password_confirmation' => 'confirmacion de contrasena',
            'tipo' => 'tipo',
            'dni_carnet' => 'dni o carnet',
            'placa_vehiculo' => 'placa del vehiculo',
            'mercado_id' => 'mercado',
            'numero_puesto' => 'numero de puesto',
            'dni_vendedor' => 'dni del vendedor',
            'nombre_establecimiento' => 'nombre del establecimiento',
            'numero_local' => 'numero de local',
            'img_puesto' => 'imagen del puesto',
            'horario_atencion' => 'horario de atencion',
            'horario_atencion.*.dia' => 'dia del horario',
            'horario_atencion.*.apertura' => 'hora de apertura',
            'horario_atencion.*.cierre' => 'hora de cierre',
            'nombre_dueno' => 'nombre del dueno',
            'ruc' => 'ruc',
            // Categorias
            'nombre' => 'nombre',
            'descripcion' => 'descripcion',
            'img' => 'imagen',
            // Estado pedido
            'color' => 'color',
            'orden' => 'orden',
            // Productos
            'categoria_id' => 'categoria',
            'mercado_id' => 'mercado',
            'precio' => 'precio',
            'stock' => 'stock',
            'img_producto' => 'imagen del producto',
            'activo' => 'activo',
            // Pedidos
            'usuario_id' => 'usuario',
            'repartidor_id' => 'repartidor',
            'estado_pedido_id' => 'estado del pedido',
            'direccion_entrega' => 'direccion de entrega',
            'referencia' => 'referencia',
            'latitud' => 'latitud',
            'longitud' => 'longitud',
            'notas' => 'notas',
            'subtotal' => 'subtotal',
            'descuento' => 'descuento',
            'costo_envio' => 'costo de envio',
            'total' => 'total',
            'items' => 'items del pedido',
            'items.*.producto_id' => 'producto del item',
            'items.*.cantidad' => 'cantidad del item',
            // Repartidor ubicacion
            'disponible' => 'disponible',
            // Resenas
            'calificacion' => 'calificacion',
            'comentario' => 'comentario',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'message' => 'No se pudo procesar la solicitud por errores de validacion.',
            'errors' => $validator->errors(),
        ], 422));
    }
}