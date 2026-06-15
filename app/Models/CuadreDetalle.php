<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuadreDetalle extends Model
{
    protected $fillable = [
        'cuadre_id',
        'tipo_combustible_id',
        'manguera_id',
        'numeracion_inicial',
        'numeracion_final',
        'galones',
        'precio',
        'total',
    ];

    protected function casts(): array
    {
        return [
            'numeracion_inicial' => 'decimal:3',
            'numeracion_final' => 'decimal:3',
            'galones' => 'decimal:3',
            'precio' => 'decimal:2',
            'total' => 'decimal:2',
        ];
    }

    public function cuadre(): BelongsTo
    {
        return $this->belongsTo(Cuadre::class);
    }

    public function manguera(): BelongsTo
    {
        return $this->belongsTo(Manguera::class);
    }

    public function tipoCombustible(): BelongsTo
    {
        return $this->belongsTo(TipoCombustible::class);
    }
}
