<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'nombre',
        'cedula',
        'telefono',
        'direccion',
        'fecha_inicio',
        'fecha_terminacion',
        'estado',
        'posicion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_inicio' => 'date',
            'fecha_terminacion' => 'date',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Empleado $empleado) {
            $empleado->attributes['estado'] = $empleado->fecha_terminacion
                ? 'cancelado'
                : 'activo';
        });
    }

    public function getEstadoAttribute(?string $value): string
    {
        if ($this->fecha_terminacion) {
            return 'Cancelado';
        }

        return ($value === 'cancelado') ? 'Cancelado' : 'Activo';
    }

    public function estadoEnBaseDeDatos(): string
    {
        return $this->getRawOriginal('estado') ?? 'activo';
    }

    public function turnos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Turno::class);
    }
}
