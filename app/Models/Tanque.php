<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tanque extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'tipo_combustible_id',
        'capacidad_maxima',
        'existencia_actual',
    ];

    protected function casts(): array
    {
        return [
            'capacidad_maxima' => 'decimal:3',
            'existencia_actual' => 'decimal:3',
        ];
    }

    public function tipoCombustible(): BelongsTo
    {
        return $this->belongsTo(TipoCombustible::class);
    }
}
