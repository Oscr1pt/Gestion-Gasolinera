<?php

namespace Database\Seeders;

use App\Models\Estacion;
use App\Models\Turno;
use Illuminate\Database\Seeder;

class EstacionTurnoSeeder extends Seeder
{
    public function run(): void
    {
        Estacion::updateOrCreate(
            ['nombre' => 'Estación Central'],
            ['ubicacion' => 'Santo Domingo, RD']
        );

        $turnos = [
            ['nombre' => 'Matutino', 'hora_inicio' => '06:00:00', 'hora_fin' => '14:00:00'],
            ['nombre' => 'Vespertino', 'hora_inicio' => '14:00:00', 'hora_fin' => '22:00:00'],
            ['nombre' => 'Nocturno', 'hora_inicio' => '22:00:00', 'hora_fin' => '06:00:00'],
        ];

        foreach ($turnos as $turno) {
            Turno::updateOrCreate(
                ['nombre' => $turno['nombre']],
                [
                    'hora_inicio' => $turno['hora_inicio'],
                    'hora_fin' => $turno['hora_fin'],
                ]
            );
        }
    }
}
