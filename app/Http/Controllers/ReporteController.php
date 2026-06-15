<?php

namespace App\Http\Controllers;

use App\Models\Cuadre;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReporteController extends Controller
{
    public function exportarCuadresCSV(Request $request): StreamedResponse
    {
        $fechaInicio = $request->input('fecha_inicio', now()->subMonth()->toDateString());
        $fechaFin = $request->input('fecha_fin', now()->toDateString());

        $cuadres = Cuadre::with(['dispensador', 'usuario'])
            ->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=reporte_cuadres_{$fechaInicio}_al_{$fechaFin}.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($cuadres) {
            $file = fopen('php://output', 'w');
            
            // UTF-8 BOM para que Excel lea acentos correctamente
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Cabeceras del CSV
            fputcsv($file, ['ID Cuadre', 'Fecha', 'Dispensador', 'Usuario', 'Efectivo', 'Boucher', 'Credito', 'Moneda', 'Gastos', 'Total Ventas', 'Diferencia']);

            foreach ($cuadres as $cuadre) {
                $totalIngresos = $cuadre->efectivo + $cuadre->boucher + $cuadre->credito + $cuadre->moneda;
                $diferencia = $totalIngresos - $cuadre->total - $cuadre->gastos;

                fputcsv($file, [
                    $cuadre->id,
                    $cuadre->created_at->format('Y-m-d H:i:s'),
                    $cuadre->dispensador->nombre ?? 'N/A',
                    $cuadre->usuario->name ?? 'N/A',
                    $cuadre->efectivo,
                    $cuadre->boucher,
                    $cuadre->credito,
                    $cuadre->moneda,
                    $cuadre->gastos,
                    $cuadre->total,
                    round($diferencia, 2)
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
