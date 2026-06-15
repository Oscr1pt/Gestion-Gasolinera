<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('configuracion.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-bold leading-tight text-gray-900">{{ __('Información del Sistema') }}</h2>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl py-6 sm:px-6 lg:px-8">
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 border border-emerald-200 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 p-4 text-red-800 border border-red-200 shadow-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6 bg-gradient-to-r from-slate-50 to-white flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Datos Principales</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Personaliza el nombre del sistema y los datos de la empresa.</p>
                </div>
            </div>
            
            <form action="{{ route('configuracion.sistema.update') }}" method="POST" class="p-6">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Sistema</label>
                    <input type="text" name="generales[nombre_sistema]" value="{{ $generales['nombre_sistema']->valor ?? 'Control Gasolinera' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombre de la Empresa</label>
                    <input type="text" name="generales[nombre_empresa]" value="{{ $generales['nombre_empresa']->valor ?? 'Gasolinera Principal' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('configuracion.index') }}" class="mr-3 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition-colors">
                        Guardar Sistema
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
