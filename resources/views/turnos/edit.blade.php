<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-900">{{ __('Editar Asignaciones de Turno') }}</h2>
            <a href="{{ route('turnos.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">Volver a Turnos</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-4xl py-6 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6 bg-gradient-to-r from-slate-50 to-white">
                <h3 class="text-xl font-bold text-gray-900">{{ $turno->nombre }}</h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($turno->hora_inicio)->format('h:i A') }} - {{ \Carbon\Carbon::parse($turno->hora_fin)->format('h:i A') }}
                </p>
            </div>

            <form method="POST" action="{{ route('turnos.update', $turno) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="col-span-1 md:col-span-3">
                        <x-input-label for="nombre" value="Nombre del turno" />
                        <x-text-input id="nombre" class="mt-1 block w-full" type="text" name="nombre" :value="old('nombre', $turno->nombre)" required autofocus />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_inicio" value="Hora de inicio" />
                        <x-text-input id="hora_inicio" class="mt-1 block w-full" type="time" name="hora_inicio" :value="old('hora_inicio', \Carbon\Carbon::parse($turno->hora_inicio)->format('H:i'))" required />
                        <x-input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="hora_fin" value="Hora de fin" />
                        <x-text-input id="hora_fin" class="mt-1 block w-full" type="time" name="hora_fin" :value="old('hora_fin', \Carbon\Carbon::parse($turno->hora_fin)->format('H:i'))" required />
                        <x-input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                    </div>
                </div>

                <div class="mb-6 pt-6 border-t border-gray-100">
                    <h4 class="text-sm font-bold uppercase tracking-wider text-gray-700">Asignar Empleados</h4>
                    <p class="text-sm text-gray-500 mt-1">Selecciona los empleados para este turno. Si un empleado está seleccionado aquí, se le removerá de cualquier otro turno al que estuviera asignado previamente.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                    @foreach($empleados as $empleado)
                        <label class="flex items-center p-4 border rounded-xl cursor-pointer transition-all hover:bg-slate-50 {{ $turno->empleados->contains($empleado->id) ? 'bg-blue-50/50 border-blue-200' : 'border-gray-200 bg-white' }}">
                            <input type="checkbox" name="empleados[]" value="{{ $empleado->id }}" 
                                {{ $turno->empleados->contains($empleado->id) ? 'checked' : '' }}
                                class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <div class="ml-4">
                                <span class="block text-sm font-bold text-gray-900">{{ $empleado->nombre }}</span>
                                @if($empleado->turnos->where('id', '!=', $turno->id)->count() > 0)
                                    <span class="block mt-0.5 text-xs text-amber-600 font-medium">También en: {{ $empleado->turnos->where('id', '!=', $turno->id)->pluck('nombre')->join(', ') }}</span>
                                @else
                                    <span class="block mt-0.5 text-xs text-gray-500">{{ $empleado->posicion ?? 'Empleado' }}</span>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('turnos.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
