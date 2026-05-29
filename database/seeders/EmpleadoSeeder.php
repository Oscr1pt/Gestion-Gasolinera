<?php

namespace Database\Seeders;

use App\Models\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    public function run(): void
    {
        $empleados = [
            [
                'nombre' => 'Carlos Ramírez López',
                'cedula' => '40212345678',
                'telefono' => '809-555-0101',
                'direccion' => 'Santo Domingo, RD',
                'posicion' => 'Administrador',
                'fecha_inicio' => '2022-03-15',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'María González Pérez',
                'cedula' => '40223456789',
                'telefono' => '809-555-0102',
                'direccion' => 'Santiago, RD',
                'posicion' => 'Cajera',
                'fecha_inicio' => '2023-01-10',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Juan Martínez Soto',
                'cedula' => '40234567890',
                'telefono' => '809-555-0103',
                'direccion' => 'La Vega, RD',
                'posicion' => 'Despachador',
                'fecha_inicio' => '2023-06-01',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Ana Lucía Fernández',
                'cedula' => '40245678901',
                'telefono' => '809-555-0104',
                'direccion' => 'Puerto Plata, RD',
                'posicion' => 'Supervisora',
                'fecha_inicio' => '2021-11-20',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Pedro Antonio Reyes',
                'cedula' => '40256789012',
                'telefono' => '809-555-0105',
                'direccion' => 'San Cristóbal, RD',
                'posicion' => 'Despachador',
                'fecha_inicio' => '2024-02-01',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Laura Isabel Méndez',
                'cedula' => '40267890123',
                'telefono' => '809-555-0106',
                'direccion' => 'Bonao, RD',
                'posicion' => 'Cajera',
                'fecha_inicio' => '2023-09-15',
                'fecha_terminacion' => '2024-12-31',
                'estado' => 'cancelado',
            ],
            [
                'nombre' => 'Roberto Jiménez Cruz',
                'cedula' => '40278901234',
                'telefono' => '809-555-0107',
                'direccion' => 'Higüey, RD',
                'posicion' => 'Despachador',
                'fecha_inicio' => '2022-08-01',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
            [
                'nombre' => 'Sofía Elena Vargas',
                'cedula' => '40289012345',
                'telefono' => '809-555-0108',
                'direccion' => 'Barahona, RD',
                'posicion' => 'Cajera',
                'fecha_inicio' => '2024-05-01',
                'fecha_terminacion' => null,
                'estado' => 'activo',
            ],
        ];

        foreach ($empleados as $empleado) {
            Empleado::updateOrCreate(
                ['cedula' => $empleado['cedula']],
                $empleado
            );
        }
    }
}
