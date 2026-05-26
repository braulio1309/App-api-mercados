<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Mercado extends Model
{
    use HasFactory;

    protected $table = 'mercados';

    protected $fillable = [
        'nombre_establecimiento',
        'numero_local',
        'img_puesto',
        'horario_atencion',
        'nombre_dueno',
        'ruc',
    ];

    protected function casts(): array
    {
        return [
            'horario_atencion' => 'array',
        ];
    }

    public function vendedores(): BelongsToMany
    {
        return $this->belongsToMany(Vendedor::class, 'vendedor_mercado')
            ->withPivot(['numero_puesto', 'dni_vendedor'])
            ->withTimestamps();
    }
}
