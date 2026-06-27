<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-800">
            {{ __('Inventario de Productos (Minimarket)') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('success')" />

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <form action="{{ route('productos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4 mb-8 bg-gray-50 p-4 rounded-xl">
                        @csrf
                        <div class="md:col-span-2">
                            <x-input-label for="nombre" value="Nombre del Producto" />
                            <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="categoria" value="Categoría" />
                            <x-text-input id="categoria" name="categoria" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="precio_venta" value="Precio Venta ($)" />
                            <x-text-input id="precio_venta" name="precio_venta" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="stock_actual" value="Stock Inicial" />
                            <x-text-input id="stock_actual" name="stock_actual" type="number" class="mt-1 block w-full" required />
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-blue-600 text-white rounded-lg px-4 py-2 font-semibold hover:bg-blue-700">Añadir</button>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-500">
                            <thead class="bg-gray-50 text-xs uppercase text-gray-700">
                                <tr>
                                    <th class="px-4 py-3">ID</th>
                                    <th class="px-4 py-3">Nombre</th>
                                    <th class="px-4 py-3">Categoría</th>
                                    <th class="px-4 py-3 text-right">Precio</th>
                                    <th class="px-4 py-3 text-right">Stock</th>
                                    <th class="px-4 py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productos as $producto)
                                    <tr class="border-b">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $producto->id }}</td>
                                        <td class="px-4 py-3 font-bold">{{ $producto->nombre }}</td>
                                        <td class="px-4 py-3">{{ $producto->categoria }}</td>
                                        <td class="px-4 py-3 text-right font-bold text-emerald-600">${{ number_format($producto->precio_venta, 2) }}</td>
                                        <td class="px-4 py-3 text-right font-bold {{ $producto->stock_actual < 10 ? 'text-red-500' : 'text-gray-700' }}">{{ $producto->stock_actual }}</td>
                                        <td class="px-4 py-3 text-center">
                                            <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline" onsubmit="return confirm('¿Borrar producto?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Borrar</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
