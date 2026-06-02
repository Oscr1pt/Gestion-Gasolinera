<?php

namespace App\Http\Controllers;

use App\Models\Cuadre;
use App\Models\CuadreDetalle;
use App\Models\Dispensador;
use App\Models\TipoCombustible;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuadreController extends Controller
{
    public function index(): View
    {
        $cuadres = Cuadre::with(['dispensador', 'detalles.tipoCombustible'])
            ->latest()
            ->paginate(10);

        return view('cuadres.index', compact('cuadres'));
    }

    public function create(): View
    {
        $dispensadores = Dispensador::orderBy('nombre')->get();
        $tiposCombustible = TipoCombustible::orderBy('nombre')->get();

        return view('cuadres.create', compact('dispensadores', 'tiposCombustible'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'dispensador_id' => 'required|exists:dispensadores,id',
            'combustibles' => 'required|array',
            'combustibles.*.tipo_combustible_id' => 'required|exists:tipos_combustible,id',
            'combustibles.*.numeracion_inicial' => 'required|numeric|min:0',
            'combustibles.*.numeracion_final' => 'required|numeric|gt:combustibles.*.numeracion_inicial',
            'combustibles.*.precio' => 'required|numeric|min:0',
        ], [
            'combustibles.*.numeracion_final.gt' => 'La numeración final debe ser mayor que la inicial.',
        ]);

        $cuadre = Cuadre::create([
            'dispensador_id' => $validated['dispensador_id'],
            'total' => 0,
        ]);

        $totalCuadre = 0;

        foreach ($validated['combustibles'] as $combustible) {
            $numeracionInicial = (float) $combustible['numeracion_inicial'];
            $numeracionFinal = (float) $combustible['numeracion_final'];
            $precio = (float) $combustible['precio'];

            $galones = $numeracionFinal - $numeracionInicial;
            $total = round($galones * $precio, 2);

            CuadreDetalle::create([
                'cuadre_id' => $cuadre->id,
                'tipo_combustible_id' => $combustible['tipo_combustible_id'],
                'numeracion_inicial' => $numeracionInicial,
                'numeracion_final' => $numeracionFinal,
                'galones' => round($galones, 3),
                'precio' => $precio,
                'total' => $total,
            ]);

            $totalCuadre += $total;
        }

        $cuadre->update(['total' => round($totalCuadre, 2)]);

        return redirect()
            ->route('cuadres.show', $cuadre)
            ->with('success', 'Cuadre registrado correctamente.');
    }

    public function show(Cuadre $cuadre): View
    {
        $cuadre->load(['dispensador', 'detalles.tipoCombustible']);

        return view('cuadres.show', compact('cuadre'));
    }
}
