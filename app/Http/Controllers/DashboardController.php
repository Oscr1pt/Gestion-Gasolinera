<?php

namespace App\Http\Controllers;

use App\Models\Cuadre;
use App\Models\Dispensador;
use App\Models\Empleado;
use App\Models\Turno;
use App\Models\Tanque;
use App\Models\VentaPos;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $hoy = Carbon::today();

        $empleadosActivos = Empleado::where('estado', 'activo')->count();
        $ventasCombustible = Cuadre::whereDate('created_at', $hoy)->sum('total');
        $ventasTienda = VentaPos::whereDate('created_at', $hoy)->sum('total');
        $ventasTotales = $ventasCombustible + $ventasTienda;
        
        $turnosActivos = Turno::where('estado', 'Activo')->count();
        $dispensadorasActivas = Dispensador::count();

        $ventasUltimaSemana = [];
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $fecha = Carbon::today()->subDays($i);
            $total = Cuadre::whereDate('created_at', $fecha)->sum('total');
            $labels[] = $fecha->format('D');
            $data[] = (float) $total;
        }

        return view('dashboard', [
            'kpis' => [
                'empleados_activos' => $empleadosActivos,
                'empleados_trend' => $empleadosActivos > 0 ? '+0 este mes' : null,
                'turnos_activos' => $turnosActivos,
                'dispensadoras' => $dispensadorasActivas,
                'ventas_combustible' => $ventasCombustible,
                'ventas_tienda' => $ventasTienda,
                'ventas_totales' => $ventasTotales,
            ],
            'chartVentasDia' => [
                'labels' => $labels,
                'data' => $data,
            ],
            'chartRendimientoEmpleados' => $this->rendimientoEmpleadosChart(),
            'chartDistribucionTurnos' => [
                'labels' => ['Mañana', 'Tarde', 'Noche'],
                'data' => [45, 30, 25], // Simulados por ahora
            ],
            'tanques' => Tanque::with('tipoCombustible')->get(),
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
