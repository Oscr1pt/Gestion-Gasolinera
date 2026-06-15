<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">{{ __('Configuración del Sistema') }}</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 border border-emerald-200 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Tarjeta Horarios de Turnos -->
            <a href="{{ route('configuracion.turnos') }}" class="group block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)] hover:shadow-md hover:border-blue-200 transition-all duration-300">
                <div class="p-6">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Horarios de Turnos</h3>
                    <p class="text-sm text-gray-500">Configura la hora de inicio y fin para los turnos matutino y nocturno.</p>
                </div>
            </a>

            <!-- Tarjeta Información del Sistema -->
            <a href="{{ route('configuracion.sistema') }}" class="group block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)] hover:shadow-md hover:border-indigo-200 transition-all duration-300">
                <div class="p-6">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Información del Sistema</h3>
                    <p class="text-sm text-gray-500">Personaliza el nombre del sistema y los datos de la empresa.</p>
                </div>
            </a>

            <!-- Tarjeta Configuración Regional -->
            <a href="{{ route('configuracion.regional') }}" class="group block overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)] hover:shadow-md hover:border-emerald-200 transition-all duration-300">
                <div class="p-6">
                    <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Configuración Regional</h3>
                    <p class="text-sm text-gray-500">Ajusta la zona horaria y el símbolo de moneda para el sistema.</p>
                </div>
            </a>

        </div>
    </div>
</x-app-layout>
