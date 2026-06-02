<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lado extends Model
{
    protected $table = 'lados';

    protected $fillable = [
        'dispensador_id',
        'nombre',
        'habilitado',
    ];

    protected function casts(): array
    {
        return [
            'habilitado' => 'boolean',
        ];
    }

    public function dispensador(): BelongsTo
    {
        return $this->belongsTo(Dispensador::class);
    }

    public function mangueras(): HasMany
    {
        return $this->hasMany(Manguera::class);
    }
}
