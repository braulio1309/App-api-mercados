<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pedido extends Model
{
    use HasFactory;

    protected $table = 'pedidos';

    protected $fillable = [
        'usuario_id',
        'mercado_id',
        'repartidor_id',
        'estado_pedido_id',
        'direccion_entrega',
        'referencia',
        'latitud',
        'longitud',
        'notas',
        'subtotal',
        'descuento',
        'costo_envio',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'latitud'    => 'decimal:7',
            'longitud'   => 'decimal:7',
            'subtotal'   => 'decimal:2',
            'descuento'  => 'decimal:2',
            'costo_envio'=> 'decimal:2',
            'total'      => 'decimal:2',
        ];
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function mercado(): BelongsTo
    {
        return $this->belongsTo(Mercado::class, 'mercado_id');
    }

    public function repartidor(): BelongsTo
    {
        return $this->belongsTo(Repartidor::class, 'repartidor_id');
    }

    public function estadoPedido(): BelongsTo
    {
        return $this->belongsTo(EstadoPedido::class, 'estado_pedido_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PedidoItem::class, 'pedido_id');
    }

    public function historialEstados(): HasMany
    {
        return $this->hasMany(HistorialEstadoPedido::class, 'pedido_id');
    }

    public function pagos(): HasMany
    {
        return $this->hasMany(Pago::class, 'pedido_id');
    }
}
