<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\VentaPos;
use App\Models\VentaPosDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $productos = Producto::where('stock_actual', '>', 0)->get();
        return view('pos.index', compact('productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrito' => 'required|array|min:1',
            'carrito.*.id' => 'required|exists:productos,id',
            'carrito.*.cantidad' => 'required|integer|min:1',
            'metodo_pago' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $totalVenta = 0;
            $venta = VentaPos::create([
                'user_id' => auth()->id() ?? 1, // Fallback en pruebas locales
                'total' => 0,
                'metodo_pago' => $validated['metodo_pago'],
            ]);

            foreach ($validated['carrito'] as $item) {
                $producto = Producto::findOrFail($item['id']);
                
                if ($producto->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para el producto: {$producto->nombre}");
                }

                $subtotal = $producto->precio_venta * $item['cantidad'];
                $totalVenta += $subtotal;

                // Restar stock
                $producto->decrement('stock_actual', $item['cantidad']);

                VentaPosDetalle::create([
                    'venta_pos_id' => $venta->id,
                    'producto_id' => $producto->id,
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $producto->precio_venta,
                    'subtotal' => $subtotal,
                ]);
            }

            $venta->update(['total' => $totalVenta]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Venta registrada exitosamente', 'venta_id' => $venta->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
