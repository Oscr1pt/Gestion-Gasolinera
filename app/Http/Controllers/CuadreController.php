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
    public function index(Request $request): View
    {
        $query = Cuadre::with(['dispensador', 'detalles.tipoCombustible'])
            ->latest();

        if ($request->filled('fecha')) {
            $query->whereDate('created_at', $request->fecha);
        }

        $cuadres = $query->paginate(10)->withQueryString();

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
            'combustibles.*.numeracion_final' => 'required|numeric|gte:combustibles.*.numeracion_inicial',
            'combustibles.*.precio' => 'required|numeric|min:0',
            'efectivo' => 'nullable|numeric|min:0',
            'boucher' => 'nullable|numeric|min:0',
            'credito' => 'nullable|numeric|min:0',
            'moneda' => 'nullable|numeric|min:0',
            'gastos' => 'nullable|numeric|min:0',
        ], [
            'combustibles.*.numeracion_final.gte' => 'La numeración final debe ser mayor o igual que la inicial.',
        ]);

        $cuadre = Cuadre::create([
            'dispensador_id' => $validated['dispensador_id'],
            'total' => 0,
            'efectivo' => $validated['efectivo'] ?? 0,
            'boucher' => $validated['boucher'] ?? 0,
            'credito' => $validated['credito'] ?? 0,
            'moneda' => $validated['moneda'] ?? 0,
            'gastos' => $validated['gastos'] ?? 0,
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
