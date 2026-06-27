<?php

namespace App\Http\Controllers;

use App\Models\Cuadre;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VentaController extends Controller
{
    public function index(Request $request): View
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $date = Carbon::createFromDate($year, $month, 1);
        $daysInMonth = $date->daysInMonth;
        
        $firstDayOfMonth = $date->copy()->startOfMonth()->dayOfWeek; // 0 (Sunday) to 6 (Saturday)

        $cuadres = Cuadre::with(['turno', 'dispensador', 'detalles.tipoCombustible', 'detalles.manguera.lado'])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->get();

        $ventasPorDia = [];
        $totalVendidoMes = 0;
        $cantidadCuadres = $cuadres->count();
        $mejorDia = ['dia' => null, 'total' => 0];

        foreach ($cuadres as $cuadre) {
            $dia = $cuadre->created_at->format('j');
            
            if (!isset($ventasPorDia[$dia])) {
                $ventasPorDia[$dia] = [
                    'total_vendido' => 0,
                    'total_efectivo' => 0,
                    'total_boucher' => 0,
                    'total_credito' => 0,
                    'total_moneda' => 0,
                    'total_gastos' => 0,
                    'total_ingresos' => 0,
                    'diferencia_general' => 0,
                    'totales_combustibles' => [],
                ];
            }
            
            if ($cuadre->dispensador) {
                foreach ($cuadre->detalles as $detalle) {
                    $combustibleNombre = $detalle->tipoCombustible ? $detalle->tipoCombustible->nombre : 'Desconocido';
                    
                    // Sum total for fuel types globally
                    if (!isset($ventasPorDia[$dia]['totales_combustibles'][$combustibleNombre])) {
                        $ventasPorDia[$dia]['totales_combustibles'][$combustibleNombre] = 0;
                    }
                    $ventasPorDia[$dia]['totales_combustibles'][$combustibleNombre] += $detalle->total;
                }
            }
            
            $ventasPorDia[$dia]['total_vendido'] += $cuadre->total;
            $ventasPorDia[$dia]['total_efectivo'] += $cuadre->efectivo;
            $ventasPorDia[$dia]['total_boucher'] += $cuadre->boucher;
            $ventasPorDia[$dia]['total_credito'] += $cuadre->credito;
            $ventasPorDia[$dia]['total_moneda'] += $cuadre->moneda;
            $ventasPorDia[$dia]['total_gastos'] += $cuadre->gastos;
            
            $ingresos = $cuadre->efectivo + $cuadre->boucher + $cuadre->credito + $cuadre->moneda;
            $ventasPorDia[$dia]['total_ingresos'] += $ingresos;
            $ventasPorDia[$dia]['diferencia_general'] += ($ingresos - $cuadre->total - $cuadre->gastos);
            
            $totalVendidoMes += $cuadre->total;
        }

        foreach ($ventasPorDia as $dia => $data) {
            if ($data['total_vendido'] > $mejorDia['total']) {
                $mejorDia = ['dia' => $dia, 'total' => $data['total_vendido']];
            }
        }

        $diasConDatos = count($ventasPorDia);
        $promedioDiario = $diasConDatos > 0 ? $totalVendidoMes / $diasConDatos : 0;

        return view('ventas.index', compact(
            'ventasPorDia',
            'month',
            'year',
            'date',
            'daysInMonth',
            'firstDayOfMonth',
            'totalVendidoMes',
            'cantidadCuadres',
            'promedioDiario',
            'mejorDia'
        ));
    }
}
