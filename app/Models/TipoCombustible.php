<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoCombustible extends Model
{
    protected $table = 'tipos_combustible';

    protected $fillable = [
        'nombre',
        'precio_por_galon',
    ];

    protected function casts(): array
    {
        return [
            'precio_por_galon' => 'decimal:2',
        ];
    }

    public function cuadreDetalles(): HasMany
    {
        return $this->hasMany(CuadreDetalle::class);
    }
}
