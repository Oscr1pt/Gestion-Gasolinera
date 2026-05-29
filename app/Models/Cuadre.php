<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cuadre extends Model
{
    protected $fillable = [
        'estacion_id',
        'turno_id',
        'fecha',
        'lectura_inicial',
        'lectura_final',
        'total_galones',
        'total_ventas',
        'efectivo',
        'boucher',
        'credito',
        'gastos',
        'monedaje',
        'total_final',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'lectura_inicial' => 'decimal:3',
            'lectura_final' => 'decimal:3',
            'total_galones' => 'decimal:3',
            'total_ventas' => 'decimal:2',
            'efectivo' => 'decimal:2',
            'boucher' => 'decimal:2',
            'credito' => 'decimal:2',
            'gastos' => 'decimal:2',
            'monedaje' => 'decimal:2',
            'total_final' => 'decimal:2',
        ];
    }

    public function estacion(): BelongsTo
    {
        return $this->belongsTo(Estacion::class);
    }

    public function turno(): BelongsTo
    {
        return $this->belongsTo(Turno::class);
    }

    protected function totalIngresos(): Attribute
    {
        return Attribute::get(
            fn () => (float) $this->efectivo + (float) $this->boucher + (float) $this->credito
        );
    }
}
