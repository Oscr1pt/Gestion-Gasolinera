<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Estacion extends Model
{
    protected $table = 'estaciones';

    protected $fillable = [
        'nombre',
        'ubicacion',
    ];

    public function cuadres(): HasMany
    {
        return $this->hasMany(Cuadre::class);
    }
}
