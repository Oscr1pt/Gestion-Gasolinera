<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ConfiguracionTurno;
use App\Models\ConfiguracionGeneral;

class ConfiguracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Turnos por defecto
        ConfiguracionTurno::updateOrCreate(
            ['turno' => 'matutino'],
            ['hora_inicio' => '06:00:00', 'hora_fin' => '14:00:00']
        );

        ConfiguracionTurno::updateOrCreate(
            ['turno' => 'nocturno'],
            ['hora_inicio' => '14:00:00', 'hora_fin' => '06:00:00'] // As per common shifts, or maybe 14:00 - 22:00 and 22:00 - 06:00? The user said "Turno Matutino: 06:00 AM — 02:00 PM, Turno Nocturno: 02:00 PM — 10:00 PM" in the current JS but then "10:01 PM — 05:59 AM" is also Nocturno.
            // Let's stick to what's in the JS right now for two shifts: Matutino 06:00-14:00, Nocturno 14:00-06:00 (since it covers the rest of the day). Wait, let's use 14:00 to 06:00 for the nocturnal shift.
        );
        ConfiguracionTurno::where('turno', 'nocturno')->update([
            'hora_inicio' => '14:00:00',
            'hora_fin' => '06:00:00'
        ]);

        // Configuraciones Generales por defecto
        $generales = [
            'nombre_sistema' => 'Control Gasolinera',
            'nombre_empresa' => 'Gasolinera Principal',
            'zona_horaria' => 'America/Santo_Domingo',
            'simbolo_moneda' => 'RD$',
        ];

        foreach ($generales as $clave => $valor) {
            ConfiguracionGeneral::updateOrCreate(
                ['clave' => $clave],
                ['valor' => $valor]
            );
        }
    }
}
