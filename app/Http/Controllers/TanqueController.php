<?php

namespace App\Http\Controllers;

use App\Models\Tanque;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TanqueController extends Controller
{
    public function index(): View
    {
        $tanques = Tanque::with('tipoCombustible')->get();
        return view('tanques.index', compact('tanques'));
    }

    public function recarga(Request $request, Tanque $tanque): RedirectResponse
    {
        $validated = $request->validate([
            'galones' => 'required|numeric|min:0.001'
        ]);

        $nuevaExistencia = $tanque->existencia_actual + $validated['galones'];

        if ($nuevaExistencia > $tanque->capacidad_maxima) {
            return back()->withErrors(['galones' => 'La recarga supera la capacidad máxima del tanque.'])->withInput();
        }

        $tanque->update([
            'existencia_actual' => $nuevaExistencia
        ]);

        return redirect()->route('tanques.index')->with('success', 'Recarga registrada exitosamente.');
    }
}
