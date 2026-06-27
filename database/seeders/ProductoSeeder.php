<?php

namespace Database\Seeders;

use App\Models\Producto;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $productos = [
            ['nombre' => 'Aceite de Motor 20W50', 'categoria' => 'Lubricantes', 'precio_venta' => 8.50, 'costo' => 5.00, 'stock_actual' => 50],
            ['nombre' => 'Refrigerante Verde Galón', 'categoria' => 'Líquidos', 'precio_venta' => 12.00, 'costo' => 7.50, 'stock_actual' => 30],
            ['nombre' => 'Aditivo Limpiador Inyectores', 'categoria' => 'Aditivos', 'precio_venta' => 4.50, 'costo' => 2.50, 'stock_actual' => 100],
            ['nombre' => 'Agua Destilada 1L', 'categoria' => 'Líquidos', 'precio_venta' => 1.50, 'costo' => 0.50, 'stock_actual' => 40],
            ['nombre' => 'Ambientador Pino', 'categoria' => 'Accesorios', 'precio_venta' => 2.00, 'costo' => 0.80, 'stock_actual' => 25],
            ['nombre' => 'Líquido de Frenos DOT 3', 'categoria' => 'Líquidos', 'precio_venta' => 5.00, 'costo' => 3.00, 'stock_actual' => 15],
            ['nombre' => 'Snack Papas Fritas', 'categoria' => 'Alimentos', 'precio_venta' => 1.00, 'costo' => 0.40, 'stock_actual' => 60],
            ['nombre' => 'Gaseosa Cola 500ml', 'categoria' => 'Alimentos', 'precio_venta' => 1.25, 'costo' => 0.60, 'stock_actual' => 80],
        ];

        foreach ($productos as $prod) {
            Producto::create($prod);
        }
    }
}
