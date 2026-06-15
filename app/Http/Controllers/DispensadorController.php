<?php

namespace App\Http\Controllers;

use App\Models\Dispensador;
use App\Models\Lado;
use App\Models\Manguera;
use App\Models\TipoCombustible;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DispensadorController extends Controller
{
    public function index(): View
    {
        $dispensadores = Dispensador::with(['lados.mangueras'])
            ->withCount('lados')
            ->withCount(['lados as mangueras_count' => function($query) {
                $query->join('mangueras', 'lados.id', '=', 'mangueras.lado_id');
            }])
            ->oldest()
            ->paginate(10);
        return view('dispensadores.index', compact('dispensadores'));
    }

    public function create(): View
    {
        return view('dispensadores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($validated, &$dispensador) {
            $dispensador = Dispensador::create([
                'nombre' => $validated['nombre'],
            ]);

            // Automatically create 2 sides (A and B)
            $lados = [
                ['nombre' => 'Lado A', 'habilitado' => true],
                ['nombre' => 'Lado B', 'habilitado' => true],
            ];

            foreach ($lados as $ladoData) {
                $lado = Lado::create([
                    'dispensador_id' => $dispensador->id,
                    'nombre' => $ladoData['nombre'],
                    'habilitado' => $ladoData['habilitado'],
                ]);

                // Automatically create 4 hoses for each side
                for ($i = 1; $i <= 4; $i++) {
                    Manguera::create([
                        'lado_id' => $lado->id,
                        'numero' => $i,
                        'habilitado' => true,
                        // El usuario lo asignará luego en 'edit'
                    ]);
                }
            }
        });

        return redirect()
            ->route('dispensadores.show', $dispensador)
            ->with('success', 'Dispensador creado con 2 lados y 8 mangueras.');
    }

    public function show(Dispensador $dispensador): View
    {
        $dispensador->load(['lados.mangueras']);
        return view('dispensadores.show', compact('dispensador'));
    }

    public function edit(Dispensador $dispensador): View
    {
        $dispensador->load(['lados.mangueras']);
        $tiposCombustible = TipoCombustible::orderBy('nombre')->get();
        return view('dispensadores.edit', compact('dispensador', 'tiposCombustible'));
    }

    public function update(Request $request, Dispensador $dispensador): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        DB::transaction(function () use ($request, $dispensador, $validated) {
            $dispensador->update([
                'nombre' => $validated['nombre'],
            ]);

            foreach ($dispensador->lados as $lado) {
                $ladoData = $request->input("lados.{$lado->id}");
                if ($ladoData !== null) {
                    $lado->update(['habilitado' => $ladoData['habilitado'] ?? 0]);
                }

                foreach ($lado->mangueras as $manguera) {
                    $mangueraData = $request->input("mangueras.{$manguera->id}");
                    if ($mangueraData !== null) {
                        $manguera->update([
                            'habilitado' => $mangueraData['habilitado'] ?? 0,
                            'tipo_combustible_id' => $mangueraData['tipo_combustible_id'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()
            ->route('dispensadores.show', $dispensador)
            ->with('success', 'Dispensador actualizado.');
    }

    public function destroy(Dispensador $dispensador): RedirectResponse
    {
        $dispensador->delete();
        return redirect()
            ->route('dispensadores.index')
            ->with('success', 'Dispensador eliminado.');
    }
}
