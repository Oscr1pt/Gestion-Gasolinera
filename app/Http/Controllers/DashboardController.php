<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $empleadosActivos = Empleado::where('estado', 'activo')->count();

        return view('dashboard', [
            'kpis' => [
                'empleados_activos' => $empleadosActivos,
                'empleados_trend' => $empleadosActivos > 0 ? '+2 este mes' : null,
                'turnos_hoy' => 3,
                'dispensadoras' => 8,
                'ventas_hoy' => 18450.00,
            ],
            'chartVentasDia' => [
                'labels' => ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                'data' => [15200, 16800, 14500, 19200, 17800, 22100, 18450],
            ],
            'chartRendimientoEmpleados' => $this->rendimientoEmpleadosChart(),
            'chartDistribucionTurnos' => [
                'labels' => ['Matutino', 'Vespertino', 'Nocturno'],
                'data' => [38, 35, 27],
            ],
        ]);
    }

    /**
     * @return array{labels: list<string>, data: list<int>}
     */
    private function rendimientoEmpleadosChart(): array
    {
        $labels = Empleado::where('estado', 'activo')
            ->limit(6)
            ->pluck('nombre')
            ->whenEmpty(fn () => collect(['Juan Pérez', 'María López', 'Carlos Ruiz', 'Ana Torres', 'Luis Méndez', 'Sofía Vega']))
            ->values()
            ->all();

        $scores = [92, 88, 95, 78, 85, 90];
        $data = [];

        foreach (array_keys($labels) as $index) {
            $data[] = $scores[$index % count($scores)];
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
