<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('configuracion.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="text-xl font-bold leading-tight text-gray-900">{{ __('Horarios de Turnos') }}</h2>
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
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Configuración de Horarios</h3>
                    <p class="text-sm text-gray-500 mt-0.5">Modifica la hora de inicio y fin para los turnos.</p>
                </div>
            </div>
            
            <form action="{{ route('configuracion.turnos.update') }}" method="POST" class="p-6">
                @csrf
                
                <div class="mb-6">
                    <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-gray-500 border-b border-gray-100 pb-2">Turno Matutino</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora Inicio</label>
                            <input type="time" name="turnos[matutino][hora_inicio]" value="{{ \Carbon\Carbon::parse($turnos['matutino']->hora_inicio ?? '06:00')->format('H:i') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora Fin</label>
                            <input type="time" name="turnos[matutino][hora_fin]" value="{{ \Carbon\Carbon::parse($turnos['matutino']->hora_fin ?? '14:00')->format('H:i') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-gray-500 border-b border-gray-100 pb-2">Turno Nocturno</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora Inicio</label>
                            <input type="time" name="turnos[nocturno][hora_inicio]" value="{{ \Carbon\Carbon::parse($turnos['nocturno']->hora_inicio ?? '14:00')->format('H:i') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Hora Fin</label>
                            <input type="time" name="turnos[nocturno][hora_fin]" value="{{ \Carbon\Carbon::parse($turnos['nocturno']->hora_fin ?? '06:00')->format('H:i') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end pt-4 border-t border-gray-100">
                    <a href="{{ route('configuracion.index') }}" class="mr-3 rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition-colors">
                        Guardar Horarios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
