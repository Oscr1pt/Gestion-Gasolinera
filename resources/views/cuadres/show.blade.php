<x-app-layout>
    <x-slot name="header">{{ __('Resumen de cuadre') }}</x-slot>

    <div class="mx-auto max-w-6xl space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Cuadre #{{ $cuadre->id }}</h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $cuadre->dispensador->nombre }} · {{ $cuadre->created_at->format('d/m/Y H:i') }}
                </p>
            </div>
            <a href="{{ route('cuadres.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                Volver al listado
            </a>
        </div>

        <div class="rounded-2xl border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Total del Cuadre</h3>
                    <p class="text-sm text-gray-500">Suma de todos los combustibles</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">${{ number_format($cuadre->total, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 px-6 py-4">
                <h3 class="font-bold text-gray-800">Desglose por Tipo de Combustible</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($cuadre->detalles as $detalle)
                    <div class="grid grid-cols-1 gap-4 px-6 py-4 sm:grid-cols-2 lg:grid-cols-4">
                        <div>
                            <p class="text-xs text-gray-500">Tipo de Combustible</p>
                            <p class="text-sm font-semibold text-gray-900">{{ $detalle->tipoCombustible->nombre }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Galones Vendidos</p>
                            <p class="text-sm font-semibold text-gray-900">{{ number_format($detalle->galones, 3) }}</p>
                            <p class="text-xs text-gray-400">{{ number_format($detalle->numeracion_inicial, 3) }} → {{ number_format($detalle->numeracion_final, 3) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Precio por Galón</p>
                            <p class="text-sm font-semibold text-gray-900">${{ number_format($detalle->precio, 2) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Total Generado</p>
                            <p class="text-sm font-bold text-blue-600">${{ number_format($detalle->total, 2) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
