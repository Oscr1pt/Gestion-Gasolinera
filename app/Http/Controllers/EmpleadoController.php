<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmpleadoController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $empleados = Empleado::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('cedula', 'like', "%{$search}%")
                        ->orWhere('telefono', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('empleados.index', compact('empleados', 'search'));
    }

    public function create(): View
    {
        return view('empleados.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:empleados',
            'telefono' => 'required|string|unique:empleados,telefono',
            'direccion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_terminacion' => 'nullable|date|after_or_equal:fecha_inicio',
            'posicion' => 'required|string|max:255',
        ]);

        Empleado::create($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function show(Empleado $empleado): View
    {
        return view('empleados.show', compact('empleado'));
    }

    public function edit(Empleado $empleado): View
    {
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, Empleado $empleado): RedirectResponse
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|unique:empleados,cedula,' . $empleado->id,
            'telefono' => 'required|string|unique:empleados,telefono,' . $empleado->id,
            'direccion' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_terminacion' => 'nullable|date|after_or_equal:fecha_inicio',
            'posicion' => 'required|string|max:255',
        ]);

        $empleado->update($validated);

        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function disable(Empleado $empleado): RedirectResponse
    {
        $empleado->update([
            'fecha_terminacion' => $empleado->fecha_terminacion ?? now()->toDateString(),
            'estado' => 'Inactivo', // Assuming there's a way to mark them inactive, maybe just setting fecha_terminacion makes them inactive in UI
        ]);

        return redirect()->route('empleados.index')->with('success', 'Empleado desactivado exitosamente.');
    }

    public function destroy(Empleado $empleado): RedirectResponse
    {
        abort_if(auth()->user()->role !== 'admin', 403, 'No tienes permisos para eliminar empleados.');

        $empleado->delete();

        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }
}
