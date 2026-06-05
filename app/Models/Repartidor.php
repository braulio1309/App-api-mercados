<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'disponible',
        'latitud',
        'longitud',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password'   => 'hashed',
            'disponible' => 'boolean',
            'latitud'    => 'decimal:7',
            'longitud'   => 'decimal:7',
        ];
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'repartidor_id');
    }

    public function resenas(): HasMany
    {
        return $this->hasMany(ResenaRepartidor::class, 'repartidor_id');
    }
}
