<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'mercado_id',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'img_producto',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'precio' => 'decimal:2',
            'stock'  => 'integer',
            'activo' => 'boolean',
        ];
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function mercado(): BelongsTo
    {
        return $this->belongsTo(Mercado::class, 'mercado_id');
    }

    public function pedidoItems(): HasMany
    {
        return $this->hasMany(PedidoItem::class, 'producto_id');
    }
}
