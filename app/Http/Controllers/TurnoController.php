<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\Empleado;
use Illuminate\Http\Request;

class TurnoController extends Controller
{
    public function index()
    {
        $turnos = Turno::with('empleados')->get();
        return view('turnos.index', compact('turnos'));
    }

    public function create()
    {
        $empleados = Empleado::all();
        return view('turnos.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'empleados' => 'nullable|array',
            'empleados.*' => 'exists:empleados,id'
        ]);

        $turno = Turno::create([
            'nombre' => $validated['nombre'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fin' => $validated['hora_fin']
        ]);

        if ($request->has('empleados')) {
            $turno->empleados()->sync($request->empleados);
        }

        return redirect()->route('turnos.index')->with('success', 'Turno creado exitosamente.');
    }

    public function edit(Turno $turno)
    {
        $empleados = Empleado::all();
        return view('turnos.edit', compact('turno', 'empleados'));
    }

    public function update(Request $request, Turno $turno)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'empleados' => 'nullable|array',
            'empleados.*' => 'exists:empleados,id'
        ]);

        $turno->update([
            'nombre' => $validated['nombre'],
            'hora_inicio' => $validated['hora_inicio'],
            'hora_fin' => $validated['hora_fin']
        ]);

        $turno->empleados()->sync($request->empleados ?? []);

        return redirect()->route('turnos.index')->with('success', 'Turno actualizado exitosamente.');
    }

    public function destroy(Turno $turno)
    {
        $turno->empleados()->detach();
        $turno->delete();

        return redirect()->route('turnos.index')->with('success', 'Turno eliminado exitosamente.');
    }
}
