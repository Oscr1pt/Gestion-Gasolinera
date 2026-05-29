<x-app-layout>
    <x-slot name="header">{{ __('Nuevo cuadre') }}</x-slot>

    <div class="mx-auto max-w-4xl">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900">Registrar cuadre</h2>
                <p class="mt-1 text-sm text-gray-500">
                    Precio combustible: <span class="font-semibold text-blue-600">${{ number_format($precioCombustible, 2) }}</span> / galón
                </p>
            </div>

            <form method="POST" action="{{ route('cuadres.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <x-input-label for="estacion_id" value="Estación" />
                        <select id="estacion_id" name="estacion_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Seleccionar estación</option>
                            @foreach($estaciones as $estacion)
                                <option value="{{ $estacion->id }}" @selected(old('estacion_id') == $estacion->id)>{{ $estacion->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estacion_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="turno_id" value="Turno" />
                        <select id="turno_id" name="turno_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                            <option value="">Seleccionar turno</option>
                            @foreach($turnos as $turno)
                                <option value="{{ $turno->id }}" @selected(old('turno_id') == $turno->id)>{{ $turno->nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('turno_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="fecha" value="Fecha" />
                        <x-text-input id="fecha" class="mt-1 block w-full" type="date" name="fecha" :value="old('fecha', now()->format('Y-m-d'))" required />
                        <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Lecturas de dispensadora</h3>
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <div>
                            <x-input-label for="lectura_inicial" value="Lectura inicial" />
                            <x-text-input id="lectura_inicial" class="mt-1 block w-full" type="number" name="lectura_inicial" step="0.001" min="0" :value="old('lectura_inicial')" required />
                            <x-input-error :messages="$errors->get('lectura_inicial')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="lectura_final" value="Lectura final" />
                            <x-text-input id="lectura_final" class="mt-1 block w-full" type="number" name="lectura_final" step="0.001" min="0" :value="old('lectura_final')" required />
                            <x-input-error :messages="$errors->get('lectura_final')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="mt-8 border-t border-gray-100 pt-6">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Ingresos y gastos</h3>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        <div>
                            <x-input-label for="efectivo" value="Efectivo" />
                            <x-text-input id="efectivo" class="mt-1 block w-full" type="number" name="efectivo" step="0.01" min="0" :value="old('efectivo', '0')" required />
                            <x-input-error :messages="$errors->get('efectivo')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="boucher" value="Boucher" />
                            <x-text-input id="boucher" class="mt-1 block w-full" type="number" name="boucher" step="0.01" min="0" :value="old('boucher', '0')" required />
                            <x-input-error :messages="$errors->get('boucher')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="credito" value="Crédito" />
                            <x-text-input id="credito" class="mt-1 block w-full" type="number" name="credito" step="0.01" min="0" :value="old('credito', '0')" required />
                            <x-input-error :messages="$errors->get('credito')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="gastos" value="Gastos" />
                            <x-text-input id="gastos" class="mt-1 block w-full" type="number" name="gastos" step="0.01" min="0" :value="old('gastos', '0')" required />
                            <x-input-error :messages="$errors->get('gastos')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="monedaje" value="Monedaje" />
                            <x-text-input id="monedaje" class="mt-1 block w-full" type="number" name="monedaje" step="0.01" min="0" :value="old('monedaje', '0')" required />
                            <x-input-error :messages="$errors->get('monedaje')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('cuadres.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Guardar cuadre
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
