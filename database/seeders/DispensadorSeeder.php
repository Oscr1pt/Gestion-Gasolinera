<?php

namespace Database\Seeders;

use App\Models\Dispensador;
use Illuminate\Database\Seeder;

class DispensadorSeeder extends Seeder
{
    public function run(): void
    {
        $dispensadores = [
            ['nombre' => 'Dispensador 1', 'numero_mangueras' => 8],
            ['nombre' => 'Dispensador 2', 'numero_mangueras' => 8],
            ['nombre' => 'Dispensador 3', 'numero_mangueras' => 8],
            ['nombre' => 'Dispensador 4', 'numero_mangueras' => 8],
        ];

        foreach ($dispensadores as $dispensador) {
            Dispensador::firstOrCreate(
                ['nombre' => $dispensador['nombre']],
                ['numero_mangueras' => $dispensador['numero_mangueras']]
            );
        }
    }
}
