<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResenaRepartidor extends Model
{
    use HasFactory;

    protected $table = 'resenas_repartidores';

    protected $fillable = [
        'pedido_id',
        'usuario_id',
        'repartidor_id',
        'calificacion',
        'comentario',
    ];

    protected function casts(): array
    {
        return [
            'calificacion' => 'integer',
        ];
    }

    public function pedido(): BelongsTo
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function repartidor(): BelongsTo
    {
        return $this->belongsTo(Repartidor::class, 'repartidor_id');
    }
}
