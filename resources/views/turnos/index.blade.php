<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold leading-tight text-gray-900">{{ __('Gestión de Turnos') }}</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
        <div class="mb-6 flex justify-end">
            <a href="{{ route('turnos.create') }}" class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-blue-700">
                + Crear Turno
            </a>
        </div>
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-emerald-50 p-4 text-emerald-800 border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($turnos as $turno)
                <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                    <div class="border-b border-gray-100 p-6 bg-gradient-to-r from-slate-50 to-white">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-bold text-gray-900">{{ $turno->nombre }}</h3>
                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-700">
                                {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($turno->hora_fin)->format('h:i A') }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h4 class="mb-4 text-xs font-bold uppercase tracking-wider text-gray-500">Empleados Asignados</h4>
                        
                        @if($turno->empleados->count() > 0)
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                @foreach($turno->empleados as $empleado)
                                    <div class="flex items-center rounded-lg border border-gray-100 p-3 shadow-sm">
                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-100 text-indigo-600 mr-3">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-semibold text-gray-900">{{ $empleado->nombre }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="rounded-lg border border-dashed border-gray-300 p-6 text-center">
                                <p class="text-sm text-gray-500">No hay empleados asignados a este turno.</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="border-t border-gray-100 bg-gray-50 px-6 py-4">
                        <a href="{{ route('turnos.edit', $turno) }}" class="inline-flex items-center justify-center w-full rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Editar Asignaciones
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
