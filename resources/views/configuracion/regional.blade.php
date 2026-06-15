<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('configuracion.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-bold leading-tight text-gray-900">{{ __('Configuración Regional') }}</h2>
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
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Ajustes Regionales</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Ajusta la zona horaria y el símbolo de moneda.</p>
                </div>
            </div>
            
            <form action="{{ route('configuracion.regional.update') }}" method="POST" class="p-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Zona Horaria</label>
                        <input type="text" name="generales[zona_horaria]" value="{{ $generales['zona_horaria']->valor ?? 'America/Santo_Domingo' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        <p class="mt-1 text-[11px] text-gray-500">Ej: America/Santo_Domingo</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Símbolo Moneda</label>
                        <input type="text" name="generales[simbolo_moneda]" value="{{ $generales['simbolo_moneda']->valor ?? 'RD$' }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                        <p class="mt-1 text-[11px] text-gray-500">Ej: RD$ o $</p>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('configuracion.index') }}" class="mr-3 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition-colors">
                        Guardar Regional
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
