<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manguera extends Model
{
    protected $table = 'mangueras';

    protected $fillable = [
        'lado_id',
        'numero',
        'habilitado',
    ];

    protected function casts(): array
    {
        return [
            'habilitado' => 'boolean',
        ];
    }

    public function lado(): BelongsTo
    {
        return $this->belongsTo(Lado::class);
    }
}
