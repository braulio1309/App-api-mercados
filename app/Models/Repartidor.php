<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Repartidor extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'repartidores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'ciudad',
        'dni_carnet',
        'celular',
        'email',
        'placa_vehiculo',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
