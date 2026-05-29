<?php

namespace App\Http\Controllers;

use App\Models\Cuadre;
use App\Models\Estacion;
use App\Models\Turno;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CuadreController extends Controller
{
    public function index(): View
    {
        $cuadres = Cuadre::with(['estacion', 'turno'])
            ->latest('fecha')
            ->latest('id')
            ->paginate(10);

        return view('cuadres.index', compact('cuadres'));
    }

    public function create(): View
    {
        $estaciones = Estacion::orderBy('nombre')->get();
        $turnos = Turno::orderBy('nombre')->get();
        $precioCombustible = config('cuadre.precio_combustible');

        return view('cuadres.create', compact('estaciones', 'turnos', 'precioCombustible'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'estacion_id' => 'required|exists:estaciones,id',
            'turno_id' => 'required|exists:turnos,id',
            'fecha' => 'required|date',
            'lectura_inicial' => 'required|numeric|min:0',
            'lectura_final' => 'required|numeric|gt:lectura_inicial',
            'efectivo' => 'required|numeric|min:0',
            'boucher' => 'required|numeric|min:0',
            'credito' => 'required|numeric|min:0',
            'gastos' => 'required|numeric|min:0',
            'monedaje' => 'required|numeric|min:0',
        ], [
            'lectura_final.gt' => 'La lectura final debe ser mayor que la lectura inicial.',
        ]);

        $exists = Cuadre::where('estacion_id', $validated['estacion_id'])
            ->where('turno_id', $validated['turno_id'])
            ->where('fecha', $validated['fecha'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors(['fecha' => 'Ya existe un cuadre para esta estación, turno y fecha.']);
        }

        $lecturaInicial = (float) $validated['lectura_inicial'];
        $lecturaFinal = (float) $validated['lectura_final'];

        $totalGalones = $lecturaFinal - $lecturaInicial;
        $precioCombustible = (float) config('cuadre.precio_combustible');
        $totalVentas = round($totalGalones * $precioCombustible, 2);

        $totalIngresos = (float) $validated['efectivo']
            + (float) $validated['boucher']
            + (float) $validated['credito'];

        $totalFinal = round($totalIngresos - (float) $validated['gastos'], 2);

        $cuadre = Cuadre::create([
            'estacion_id' => $validated['estacion_id'],
            'turno_id' => $validated['turno_id'],
            'fecha' => $validated['fecha'],
            'lectura_inicial' => $lecturaInicial,
            'lectura_final' => $lecturaFinal,
            'total_galones' => round($totalGalones, 3),
            'total_ventas' => $totalVentas,
            'efectivo' => $validated['efectivo'],
            'boucher' => $validated['boucher'],
            'credito' => $validated['credito'],
            'gastos' => $validated['gastos'],
            'monedaje' => $validated['monedaje'],
            'total_final' => $totalFinal,
        ]);

        return redirect()
            ->route('cuadres.show', $cuadre)
            ->with('success', 'Cuadre registrado correctamente.');
    }

    public function show(Cuadre $cuadre): View
    {
        $cuadre->load(['estacion', 'turno']);

        return view('cuadres.show', compact('cuadre'));
    }
}
