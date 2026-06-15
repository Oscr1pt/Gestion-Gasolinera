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
                    <select id="dispensador_id" name="dispensador_id" class="mt-1 block w-full rounded-lg border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500" required x-model="selectedDispensadorId" @change="loadDispensador()">
                        <option value="">Seleccionar dispensador</option>
                        <template x-for="dispensador in dispensadoresData" :key="dispensador.id">
                            <option :value="dispensador.id" x-text="dispensador.nombre" :selected="dispensador.id == selectedDispensadorId"></option>
                        </template>
                    </select>
                    <x-input-error :messages="$errors->get('dispensador_id')" class="mt-2" />
                </div>

                <template x-if="lados.length === 0 && selectedDispensadorId">
                    <div class="mb-8 rounded-lg bg-yellow-50 p-4 border border-yellow-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Atención</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Este dispensador no tiene mangueras activas o combustibles asignados. Ve al módulo de dispensadores para configurarlo.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-for="lado in lados" :key="lado.id">
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="mb-4 text-lg font-bold uppercase tracking-wider text-blue-600" x-text="lado.nombre"></h3>
                        
                        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                            <template x-for="manguera in lado.mangueras" :key="manguera.id">
                                <div class="rounded-2xl border border-gray-200 bg-slate-50 p-5">
                                    <h4 class="mb-4 text-lg font-bold text-gray-900">
                                        <span x-text="manguera.tipo_combustible.nombre"></span> 
                                        <span class="text-sm font-normal text-gray-500">(Manguera <span x-text="manguera.numero"></span>)</span>
                                    </h4>
                                    
                                    <input type="hidden" :name="`combustibles[${manguera.formIndex}][tipo_combustible_id]`" :value="manguera.tipo_combustible.id">
                                    <input type="hidden" :name="`combustibles[${manguera.formIndex}][manguera_id]`" :value="manguera.id">
                                    
                                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Numeración Inicial</label>
                                            <input 
                                                type="number" 
                                                :name="`combustibles[${manguera.formIndex}][numeracion_inicial]`" 
                                                step="0.001" 
                                                min="0" 
                                                class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                                required
                                                x-model="combustibles[manguera.formIndex].numeracion_inicial"
                                                @input="calculateCombustible(manguera.formIndex)"
                                            >
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Numeración Final</label>
                                            <input 
                                                type="number" 
                                                :name="`combustibles[${manguera.formIndex}][numeracion_final]`" 
                                                step="0.001" 
                                                min="0" 
                                                class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                                required
                                                x-model="combustibles[manguera.formIndex].numeracion_final"
                                                @input="calculateCombustible(manguera.formIndex)"
                                            >
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Precio por Galón ($)</label>
                                            <input 
                                                type="number" 
                                                :name="`combustibles[${manguera.formIndex}][precio]`" 
                                                step="0.01" 
                                                min="0" 
                                                class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                                                required
                                                x-model="combustibles[manguera.formIndex].precio"
                                                @input="calculateCombustible(manguera.formIndex)"
                                            >
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-4 rounded-lg bg-white p-3 border border-gray-200">
                                        <div>
                                            <p class="text-xs text-gray-500">Galones</p>
                                            <p class="text-lg font-bold text-gray-900" x-text="(combustibles[manguera.formIndex].galones || 0).toFixed(3)">0.000</p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-500">Total</p>
                                            <p class="text-lg font-bold text-blue-600" x-text="'$' + (combustibles[manguera.formIndex].total || 0).toFixed(2)">$0.00</p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>

                <div x-show="lados.length > 0">
                    <div class="mb-8 border-t border-gray-100 pt-6">
                        <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Ingresos y Gastos</h3>
                        
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-5">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Efectivo ($)</label>
                                <input type="number" name="efectivo" step="0.01" min="0" class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" x-model.number="efectivo">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Boucher ($)</label>
                                <input type="number" name="boucher" step="0.01" min="0" class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" x-model.number="boucher">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Crédito ($)</label>
                                <input type="number" name="credito" step="0.01" min="0" class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" x-model.number="credito">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Moneda ($)</label>
                                <input type="number" name="moneda" step="0.01" min="0" class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500" x-model.number="moneda">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Gastos ($)</label>
                                <input type="number" name="gastos" step="0.01" min="0" class="block w-full rounded-lg border-gray-200 bg-white px-3 py-2 text-sm focus:border-red-500 focus:ring-red-500" x-model.number="gastos">
                            </div>
                        </div>
                    </div>

                    <div class="mb-8 rounded-2xl border border-gray-200 bg-slate-50 p-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 divide-y md:divide-y-0 md:divide-x divide-gray-200 text-center">
                            <div class="pt-4 md:pt-0">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Ventas (Combustibles)</p>
                                <p class="text-3xl font-bold text-gray-900 mt-2" x-text="'$' + totalCuadre.toFixed(2)">$0.00</p>
                            </div>
                            <div class="pt-4 md:pt-0">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Total Ingresos</p>
                                <p class="text-3xl font-bold text-blue-600 mt-2" x-text="'$' + totalIngresos.toFixed(2)">$0.00</p>
                            </div>
                            <div class="pt-4 md:pt-0">
                                <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">Diferencia Final</p>
                                <p class="text-3xl font-bold mt-2" 
                                :class="{'text-emerald-600': diferencia >= 0, 'text-red-600': diferencia < 0}"
                                x-text="diferencia < 0 ? '-$' + Math.abs(diferencia).toFixed(2) : '$' + Math.abs(diferencia).toFixed(2)">$0.00</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('cuadres.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" x-show="lados.length > 0" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Guardar cuadre
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function cuadreForm() {
            return {
                dispensadoresData: @json($dispensadores),
                selectedDispensadorId: '{{ old('dispensador_id', '') }}',
                lados: [],
                combustibles: {},
                efectivo: '',
                boucher: '',
                credito: '',
                moneda: '',
                gastos: '',
                
                loadDispensador() {
                    this.lados = [];
                    this.combustibles = {};
                    if (!this.selectedDispensadorId) return;
                    
                    const dispensador = this.dispensadoresData.find(d => d.id == this.selectedDispensadorId);
                    if (!dispensador) return;
                    
                    let combIndex = 0;
                    dispensador.lados.forEach(lado => {
                        if (lado.habilitado) {
                            let mangueras = lado.mangueras.filter(m => m.habilitado && m.tipo_combustible);
                            if (mangueras.length > 0) {
                                this.lados.push({
                                    id: lado.id,
                                    nombre: lado.nombre,
                                    mangueras: mangueras.map(m => {
                                        const cId = combIndex++;
                                        this.combustibles[cId] = {
                                            tipo_combustible_id: m.tipo_combustible.id,
                                            numeracion_inicial: 0,
                                            numeracion_final: 0,
                                            precio: parseFloat(m.tipo_combustible.precio_por_galon) || 0,
                                            galones: 0,
                                            total: 0
                                        };
                                        return { ...m, formIndex: cId };
                                    })
                                });
                            }
                        }
                    });
                },
                
                get totalCuadre() {
                    let sum = 0;
                    Object.values(this.combustibles).forEach(c => {
                        sum += (c.total || 0);
                    });
                    return sum;
                },
                
                get totalIngresos() {
                    return (parseFloat(this.efectivo) || 0) + 
                           (parseFloat(this.boucher) || 0) + 
                           (parseFloat(this.credito) || 0) + 
                           (parseFloat(this.moneda) || 0);
                },
                
                get diferencia() {
                    return this.totalIngresos - this.totalCuadre - (parseFloat(this.gastos) || 0);
                },
                
                calculateCombustible(index) {
                    const c = this.combustibles[index];
                    if (c) {
                        c.galones = Math.max(0, (parseFloat(c.numeracion_final) || 0) - (parseFloat(c.numeracion_inicial) || 0));
                        c.total = c.galones * c.precio;
                    }
                },
                
                init() {
                    if (this.selectedDispensadorId) {
                        this.loadDispensador();
                    }
                }
            }
        }
    </script>
</x-app-layout>
