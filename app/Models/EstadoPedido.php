<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoPedido extends Model
{
    use HasFactory;

    protected $table = 'estado_pedidos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'color',
        'orden',
    ];

    protected function casts(): array
    {
        return [
            'orden' => 'integer',
        ];
    }

    public function pedidos(): HasMany
    {
        return $this->hasMany(Pedido::class, 'estado_pedido_id');
    }

    public function historialPedidos(): HasMany
    {
        return $this->hasMany(HistorialEstadoPedido::class, 'estado_pedido_id');
    }
}
