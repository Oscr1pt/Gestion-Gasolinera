<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Turno extends Model
{
    protected $fillable = [
        'nombre',
        'hora_inicio',
        'hora_fin',
    ];

    public function cuadres(): HasMany
    {
        return $this->hasMany(Cuadre::class);
    }

    public function empleados(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Empleado::class);
    }
}
