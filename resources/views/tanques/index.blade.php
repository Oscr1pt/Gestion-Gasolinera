<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold leading-tight text-gray-800">
                {{ __('Inventario de Tanques') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-auth-session-status class="mb-4" :status="session('success')" />

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                @foreach ($tanques as $tanque)
                    @php
                        $porcentaje = $tanque->capacidad_maxima > 0 ? ($tanque->existencia_actual / $tanque->capacidad_maxima) * 100 : 0;
                        $color = $porcentaje > 50 ? 'bg-emerald-500' : ($porcentaje > 20 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    <div class="overflow-hidden rounded-2xl bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-bold text-gray-900">{{ $tanque->nombre }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $tanque->tipoCombustible->nombre ?? 'N/A' }}</p>

                            <div class="mb-2 flex justify-between">
                                <span class="text-sm font-medium text-gray-700">Nivel de Combustible</span>
                                <span class="text-sm font-medium text-gray-700">{{ number_format($porcentaje, 1) }}%</span>
                            </div>
                            <div class="w-full overflow-hidden rounded-full bg-gray-200">
                                <div class="h-4 rounded-full {{ $color }}" style="width: {{ $porcentaje }}%"></div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-2 gap-4 text-center border-t border-gray-100 pt-4">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Capacidad Máx.</p>
                                    <p class="font-semibold text-gray-900">{{ number_format($tanque->capacidad_maxima, 2) }} gal</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase">Existencia Actual</p>
                                    <p class="font-semibold {{ $porcentaje < 20 ? 'text-red-600' : 'text-emerald-600' }}">
                                        {{ number_format($tanque->existencia_actual, 2) }} gal
                                    </p>
                                </div>
                            </div>

                            <form action="{{ route('tanques.recarga', $tanque) }}" method="POST" class="mt-6 border-t border-gray-100 pt-4" x-data="{ open: false }">
                                @csrf
                                <div x-show="!open" class="text-center">
                                    <button type="button" @click="open = true" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                        + Registrar descarga de proveedor
                                    </button>
                                </div>
                                
                                <div x-show="open" style="display: none;" class="space-y-3">
                                    <div>
                                        <x-input-label for="galones_{{ $tanque->id }}" value="Galones Recargados" />
                                        <x-text-input id="galones_{{ $tanque->id }}" name="galones" type="number" step="0.001" min="0.001" class="mt-1 block w-full text-sm" required placeholder="Ej: 1500" />
                                        <x-input-error :messages="$errors->get('galones')" class="mt-2" />
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="button" @click="open = false" class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="w-full rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700">
                                            Guardar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
