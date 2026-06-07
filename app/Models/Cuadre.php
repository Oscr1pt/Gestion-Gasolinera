<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cuadre extends Model
{
    protected $fillable = [
        'dispensador_id',
        'total',
        'efectivo',
        'boucher',
        'credito',
        'moneda',
        'gastos',
    ];

    protected function casts(): array
    {
        return [
            'total' => 'decimal:2',
            'efectivo' => 'decimal:2',
            'boucher' => 'decimal:2',
            'credito' => 'decimal:2',
            'moneda' => 'decimal:2',
            'gastos' => 'decimal:2',
        ];
    }

    public function getTotalIngresosAttribute(): float
    {
        return (float) ($this->efectivo + $this->boucher + $this->credito + $this->moneda);
    }

    public function getDiferenciaAttribute(): float
    {
        return (float) ($this->total_ingresos - $this->total - $this->gastos);
    }

    public function dispensador(): BelongsTo
    {
        return $this->belongsTo(Dispensador::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(CuadreDetalle::class);
    }
}
