<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispensador extends Model
{
    protected $table = 'dispensadores';

    protected $fillable = [
        'nombre',
    ];

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function lados(): HasMany
    {
        return $this->hasMany(Lado::class);
    }

    public function cuadres(): HasMany
    {
        return $this->hasMany(Cuadre::class);
    }
}
