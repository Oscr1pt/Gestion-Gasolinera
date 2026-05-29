<x-app-layout>
    <x-slot name="header">{{ __('Resumen de cuadre') }}</x-slot>

    <div class="mx-auto max-w-4xl space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Cuadre #{{ $cuadre->id }}</h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ $cuadre->estacion->nombre }} · {{ $cuadre->turno->nombre }} · {{ $cuadre->fecha->format('d/m/Y') }}
                </p>
            </div>
            <a href="{{ route('cuadres.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                Volver al listado
            </a>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-blue-600">Galones vendidos</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($cuadre->total_galones, 3) }}</p>
                <p class="mt-1 text-xs text-gray-500">Lectura {{ number_format($cuadre->lectura_inicial, 3) }} → {{ number_format($cuadre->lectura_final, 3) }}</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-emerald-600">Total ventas</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($cuadre->total_ventas, 2) }}</p>
                <p class="mt-1 text-xs text-gray-500">Calculado por galones × precio combustible</p>
            </div>
            <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-indigo-600">Total ingresos</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($cuadre->total_ingresos, 2) }}</p>
                <p class="mt-1 text-xs text-gray-500">Efectivo + boucher + crédito</p>
            </div>
            <div class="rounded-2xl border border-orange-100 bg-gradient-to-br from-orange-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-orange-600">Total final</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">${{ number_format($cuadre->total_final, 2) }}</p>
                <p class="mt-1 text-xs text-gray-500">Ingresos − gastos</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 px-6 py-4">
                <h3 class="font-bold text-gray-800">Detalle del registro</h3>
            </div>
            <dl class="divide-y divide-gray-50">
                <div class="grid grid-cols-2 gap-4 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm text-gray-500">Efectivo</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">${{ number_format($cuadre->efectivo, 2) }}</dd>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm text-gray-500">Boucher</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">${{ number_format($cuadre->boucher, 2) }}</dd>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm text-gray-500">Crédito</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">${{ number_format($cuadre->credito, 2) }}</dd>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm text-gray-500">Gastos</dt>
                    <dd class="text-sm font-semibold text-red-600 sm:col-span-2">${{ number_format($cuadre->gastos, 2) }}</dd>
                </div>
                <div class="grid grid-cols-2 gap-4 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm text-gray-500">Monedaje</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">${{ number_format($cuadre->monedaje, 2) }}</dd>
                </div>
            </dl>
        </div>
    </div>
</x-app-layout>
