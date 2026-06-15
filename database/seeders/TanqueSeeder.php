<?php

namespace Database\Seeders;

use App\Models\Tanque;
use App\Models\TipoCombustible;
use Illuminate\Database\Seeder;

class TanqueSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = TipoCombustible::all();

        foreach ($tipos as $tipo) {
            // Cada tanque de 10,000 galones con 5,000 iniciales, como ejemplo
            Tanque::firstOrCreate(
                ['nombre' => 'Tanque ' . $tipo->nombre, 'tipo_combustible_id' => $tipo->id],
                ['capacidad_maxima' => 10000, 'existencia_actual' => 5000]
            );
        }
    }
}
