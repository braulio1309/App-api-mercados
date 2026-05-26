<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Vendedor extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $table = 'vendedores';

    protected $fillable = [
        'nombres',
        'apellidos',
        'celular',
        'dni_carnet',
        'email',
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

    public function mercados(): BelongsToMany
    {
        return $this->belongsToMany(Mercado::class, 'vendedor_mercado')
            ->withPivot(['numero_puesto', 'dni_vendedor'])
            ->withTimestamps();
    }
}
