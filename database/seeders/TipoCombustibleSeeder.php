<?php

namespace Database\Seeders;

use App\Models\TipoCombustible;
use Illuminate\Database\Seeder;

class TipoCombustibleSeeder extends Seeder
{
    public function run(): void
    {
        $tipos = [
            ['nombre' => 'Gasolina Premium', 'precio_por_galon' => 285.50],
            ['nombre' => 'Gasolina Regular', 'precio_por_galon' => 265.00],
            ['nombre' => 'Diesel Premium', 'precio_por_galon' => 245.00],
            ['nombre' => 'Diesel Regular', 'precio_por_galon' => 225.00],
        ];

        foreach ($tipos as $tipo) {
            TipoCombustible::firstOrCreate(
                ['nombre' => $tipo['nombre']],
                ['precio_por_galon' => $tipo['precio_por_galon']]
            );
        }
    }
}
