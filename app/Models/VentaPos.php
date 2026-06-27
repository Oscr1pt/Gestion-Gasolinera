<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VentaPos extends Model
{
    protected $table = 'venta_pos';

    protected $fillable = [
        'user_id',
        'total',
        'metodo_pago',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(VentaPosDetalle::class, 'venta_pos_id');
    }
}
