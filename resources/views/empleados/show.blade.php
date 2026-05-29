<x-app-layout>
    <x-slot name="header">{{ __('Ver empleado') }}</x-slot>

    <div class="mx-auto max-w-3xl space-y-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">{{ $empleado->nombre }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $empleado->posicion }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('empleados.edit', $empleado) }}" class="rounded-lg bg-blue-50 px-4 py-2 text-sm font-medium text-blue-600 hover:bg-blue-100">Editar</a>
                <a href="{{ route('empleados.index', request()->only('search')) }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">Volver</a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="flex items-center gap-4 border-b border-gray-100 p-6">
                <img
                    class="h-16 w-16 rounded-full object-cover shadow-sm"
                    src="https://ui-avatars.com/api/?name={{ urlencode($empleado->nombre) }}&background=3b82f6&color=fff&bold=true&size=128"
                    alt="{{ $empleado->nombre }}"
                />
                <div>
                    <span class="{{ $empleado->estado === 'Activo' ? 'inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700' : 'inline-flex rounded-full bg-red-100 px-2.5 py-1 text-[11px] font-bold text-red-700' }}">
                        {{ $empleado->estado }}
                    </span>
                </div>
            </div>

            <dl class="divide-y divide-gray-50">
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Cédula</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">{{ $empleado->cedula }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">{{ $empleado->telefono }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Posición</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">{{ $empleado->posicion }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                    <dd class="text-sm text-gray-900 sm:col-span-2">{{ $empleado->direccion }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Fecha de inicio</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">{{ $empleado->fecha_inicio->format('d/m/Y') }}</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Fecha de terminación</dt>
                    <dd class="text-sm font-semibold text-gray-900 sm:col-span-2">
                        {{ $empleado->fecha_terminacion ? $empleado->fecha_terminacion->format('d/m/Y') : '—' }}
                    </dd>
                </div>
                <div class="grid grid-cols-1 gap-2 px-6 py-4 sm:grid-cols-3">
                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                    <dd class="text-sm font-semibold sm:col-span-2 {{ $empleado->estado === 'Activo' ? 'text-emerald-600' : 'text-red-600' }}">
                        {{ $empleado->estado }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-app-layout>
