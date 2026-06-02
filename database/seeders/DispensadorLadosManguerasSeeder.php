<?php

namespace Database\Seeders;

use App\Models\Dispensador;
use App\Models\Lado;
use App\Models\Manguera;
use Illuminate\Database\Seeder;

class DispensadorLadosManguerasSeeder extends Seeder
{
    public function run(): void
    {
        $dispensadores = Dispensador::all();

        foreach ($dispensadores as $dispensador) {
            // Check if lados already exist for this dispensador
            if ($dispensador->lados()->count() > 0) {
                continue;
            }

            // Create 2 sides (A and B)
            $lados = [
                ['nombre' => 'Lado A', 'habilitado' => true],
                ['nombre' => 'Lado B', 'habilitado' => true],
            ];

            foreach ($lados as $ladoData) {
                $lado = Lado::create([
                    'dispensador_id' => $dispensador->id,
                    'nombre' => $ladoData['nombre'],
                    'habilitado' => $ladoData['habilitado'],
                ]);

                // Create 4 hoses for each side
                for ($i = 1; $i <= 4; $i++) {
                    Manguera::create([
                        'lado_id' => $lado->id,
                        'numero' => $i,
                        'habilitado' => true,
                    ]);
                }
            }
        }
    }
}
