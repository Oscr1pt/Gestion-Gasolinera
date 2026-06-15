<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionTurno extends Model
{
    use HasFactory;

    protected $table = 'configuraciones_turnos';

    protected $fillable = [
        'turno',
        'hora_inicio',
        'hora_fin',
    ];
}
