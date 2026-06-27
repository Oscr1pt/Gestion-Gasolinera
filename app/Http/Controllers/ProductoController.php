<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        Producto::create($validated);
        return redirect()->back()->with('success', 'Producto creado exitosamente.');
    }

    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'categoria' => 'required|string|max:255',
            'precio_venta' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'stock_actual' => 'required|integer|min:0',
        ]);

        $producto->update($validated);
        return redirect()->back()->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->back()->with('success', 'Producto eliminado.');
    }
}
