<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VentaPosDetalle extends Model
{
    protected $table = 'venta_pos_detalles';

    protected $fillable = [
        'venta_pos_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    public function venta(): BelongsTo
    {
        return $this->belongsTo(VentaPos::class, 'venta_pos_id');
    }

    public function producto(): BelongsTo
    {
        return $this->belongsTo(Producto::class);
    }
}
