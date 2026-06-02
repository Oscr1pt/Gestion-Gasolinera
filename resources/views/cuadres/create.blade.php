<x-app-layout>
    <x-slot name="header">{{ __('Nuevo cuadre') }}</x-slot>

    <div class="mx-auto max-w-6xl">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900">Registrar cuadre</h2>
                <p class="mt-1 text-sm text-gray-500">Ingresa las lecturas por tipo de combustible</p>
            </div>

            <form method="POST" action="{{ route('cuadres.store') }}" class="p-6" x-data="cuadreForm()">
                @csrf

                <div class="mb-8">
                    <x-input-label for="dispensador_id" value="Dispensador" />
                    <select id="dispensador_id" name="dispensador_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                        <option value="">Seleccionar dispensador</option>
                        @foreach($dispensadores as $dispensador)
                            <option value="{{ $dispensador->id }}" @selected(old('dispensador_id') == $dispensador->id)>{{ $dispensador->nombre }} ({{ $dispensador->numero_mangueras }} mangueras)</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('dispensador_id')" class="mt-2" />
                </div>

                <div class="mb-8 border-t border-gray-100 pt-6">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Tipos de Combustible</h3>
                    
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        @foreach($tiposCombustible as $index => $tipo)
                            <div class="rounded-2xl border border-gray-200 bg-slate-50 p-5">
                                <h4 class="mb-4 text-lg font-bold text-gray-900">{{ $tipo->nombre }}</h4>
                                
                                <input type="hidden" name="combustibles[{{ $index }}][tipo_combustible_id]" value="{{ $tipo->id }}">
                                
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Numeración Inicial</label>
                                        <input 
                                            type="number" 
                                            name="combustibles[{{ $index }}][numeracion_inicial]" 
                                            step="0.001" 
                                            min="0" 
                                            class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            required
                                            x-model="combustibles[{{ $index }}].numeracion_inicial"
                                            @input="calculateCombustible({{ $index }})"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Numeración Final</label>
                                        <input 
                                            type="number" 
                                            name="combustibles[{{ $index }}][numeracion_final]" 
                                            step="0.001" 
                                            min="0" 
                                            class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            required
                                            x-model="combustibles[{{ $index }}].numeracion_final"
                                            @input="calculateCombustible({{ $index }})"
                                        >
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio por Galón ($)</label>
                                        <input 
                                            type="number" 
                                            name="combustibles[{{ $index }}][precio]" 
                                            step="0.01" 
                                            min="0" 
                                            :value="number_format($tipo->precio_por_galon, 2)"
                                            class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                            required
                                            x-model="combustibles[{{ $index }}].precio"
                                            @input="calculateCombustible({{ $index }})"
                                        >
                                    </div>
                                </div>
                                
                                <div class="mt-4 grid grid-cols-2 gap-4 rounded-lg bg-white p-3 border border-gray-200">
                                    <div>
                                        <p class="text-xs text-gray-500">Galones</p>
                                        <p class="text-lg font-bold text-gray-900" x-text="combustibles[{{ $index }}].galones.toFixed(3)">0.000</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500">Total</p>
                                        <p class="text-lg font-bold text-blue-600" x-text="'$' + combustibles[{{ $index }}].total.toFixed(2)">$0.00</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-8 rounded-2xl border border-blue-200 bg-gradient-to-br from-blue-50 to-white p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Total del Cuadre</h3>
                            <p class="text-sm text-gray-500">Suma de todos los combustibles</p>
                        </div>
                        <div class="text-right">
                            <p class="text-3xl font-bold text-blue-600" x-text="'$' + totalCuadre.toFixed(2)">$0.00</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('cuadres.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Guardar cuadre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function cuadreForm() {
            return {
                combustibles: [
                    @foreach($tiposCombustible as $tipo)
                        {
                            numeracion_inicial: 0,
                            numeracion_final: 0,
                            precio: {{ $tipo->precio_por_galon }},
                            galones: 0,
                            total: 0
                        },
                    @endforeach
                ],
                get totalCuadre() {
                    return this.combustibles.reduce((sum, c) => sum + c.total, 0);
                },
                calculateCombustible(index) {
                    const c = this.combustibles[index];
                    c.galones = c.numeracion_final - c.numeracion_inicial;
                    c.total = c.galones * c.precio;
                }
            }
        }
    </script>
</x-app-layout>
