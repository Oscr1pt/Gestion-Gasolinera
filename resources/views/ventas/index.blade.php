<x-app-layout>
    <x-slot name="header">{{ __('Ventas Mensuales') }}</x-slot>

    <div class="space-y-6" x-data="{ 
        modalOpen: false, 
        selectedDay: null, 
        dayData: null,
        openModal(dia, data) {
            this.selectedDay = dia;
            this.dayData = data;
            this.modalOpen = true;
        }
    }">
        <!-- Tarjetas Superiores (Resumen) -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                <p class="text-sm font-medium text-gray-500">Total vendido del mes</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">RD$ {{ number_format($totalVendidoMes, 2) }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                <p class="text-sm font-medium text-gray-500">Cantidad de cuadres</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $cantidadCuadres }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                <p class="text-sm font-medium text-gray-500">Promedio diario</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">RD$ {{ number_format($promedioDiario, 2) }}</p>
            </div>
            <div class="rounded-2xl border border-gray-100 bg-white p-6 shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
                <p class="text-sm font-medium text-gray-500">Mejor día del mes</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $mejorDia['dia'] ? 'Día ' . $mejorDia['dia'] : 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Calendario Contenedor -->
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            
            <!-- Navegación y Filtros -->
            <div class="flex flex-col items-center justify-between gap-4 border-b border-gray-100 p-6 sm:flex-row">
                <h2 class="text-xl font-bold text-gray-900 capitalize">{{ $date->translatedFormat('F Y') }}</h2>
                
                <div class="flex items-center gap-2">
                    <a href="{{ route('ventas.index', ['month' => $date->copy()->subMonth()->month, 'year' => $date->copy()->subMonth()->year]) }}" 
                       class="inline-flex rounded-lg bg-gray-50 p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                        ◀ Mes anterior
                    </a>
                    
                    <a href="{{ route('ventas.index') }}" 
                       class="inline-flex rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Ir a Hoy
                    </a>
                    
                    <a href="{{ route('ventas.index', ['month' => $date->copy()->addMonth()->month, 'year' => $date->copy()->addMonth()->year]) }}" 
                       class="inline-flex rounded-lg bg-gray-50 p-2 text-gray-600 hover:bg-gray-100 hover:text-gray-900">
                        Mes siguiente ▶
                    </a>
                </div>
            </div>

            <!-- Grilla Calendario -->
            <div class="p-6">
                <div class="grid grid-cols-7 gap-px rounded-lg bg-gray-200">
                    <!-- Días de la semana -->
                    @foreach(['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'] as $dayName)
                        <div class="bg-slate-50 py-2 text-center text-xs font-semibold tracking-wider text-gray-500 uppercase">
                            {{ $dayName }}
                        </div>
                    @endforeach

                    <!-- Espacios vacíos previos -->
                    @for($i = 0; $i < $firstDayOfMonth; $i++)
                        <div class="min-h-[120px] bg-white p-2"></div>
                    @endfor

                    <!-- Días del mes -->
                    @for($dia = 1; $dia <= $daysInMonth; $dia++)
                        @php
                            $hasData = isset($ventasPorDia[$dia]);
                            $data = $hasData ? $ventasPorDia[$dia] : null;
                            $bgColor = $hasData ? 'bg-emerald-50 hover:bg-emerald-100 cursor-pointer transition-colors' : 'bg-white';
                        @endphp
                        
                        <div class="min-h-[120px] flex flex-col p-2 {{ $bgColor }}"
                             @if($hasData) @click="openModal({{ $dia }}, {{ json_encode($data) }})" @endif>
                            
                            <span class="text-sm font-bold {{ $hasData ? 'text-emerald-700' : 'text-gray-400' }}">
                                {{ $dia }}
                            </span>
                            
                            <div class="mt-auto pt-4 text-center">
                                @if($hasData)
                                    <div class="inline-flex flex-col items-center justify-center">
                                        <span class="text-[10px] font-medium uppercase tracking-wider text-emerald-600">Total Vendido</span>
                                        <span class="text-sm font-bold text-emerald-800">
                                            RD$ {{ number_format($data['total_vendido'], 2) }}
                                        </span>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-300">No hay registros</span>
                                @endif
                            </div>
                        </div>
                    @endfor
                    
                    <!-- Espacios vacíos posteriores -->
                    @php
                        $totalCells = $firstDayOfMonth + $daysInMonth;
                        $remainingCells = $totalCells % 7 == 0 ? 0 : 7 - ($totalCells % 7);
                    @endphp
                    @for($i = 0; $i < $remainingCells; $i++)
                        <div class="min-h-[120px] bg-white p-2"></div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- Modal de Detalle (Alpine) -->
        <div x-show="modalOpen" 
             style="display: none;"
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" 
             role="dialog" 
             aria-modal="true">
             
            <div class="flex min-h-screen items-end justify-center px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                
                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0" 
                     x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100" 
                     x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="modalOpen = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:h-screen sm:align-middle" aria-hidden="true">&#8203;</span>

                <div x-show="modalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block transform overflow-hidden rounded-2xl bg-white text-left align-bottom shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-4xl sm:align-middle">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 w-full text-center sm:mt-0 sm:text-left">
                                <h3 class="text-2xl font-bold leading-6 text-gray-900" id="modal-title">
                                    Detalle del Día <span x-text="String(selectedDay).padStart(2, '0')"></span>/{{ $date->format('m/Y') }}
                                </h3>
                                
                                <div class="mt-6 space-y-6" x-if="dayData">
                                    <!-- RESUMEN GENERAL DEL DÍA -->
                                    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-6 shadow-sm">
                                        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 border-b border-emerald-200/60 pb-4">
                                            <div>
                                                <p class="text-sm font-bold text-emerald-700 uppercase tracking-widest">Resumen General</p>
                                            </div>
                                            <div class="text-right mt-4 md:mt-0">
                                                <p class="text-xs text-emerald-600 uppercase tracking-widest font-semibold">Total Vendido</p>
                                                <p class="text-3xl font-extrabold text-emerald-800">RD$ <span x-text="Number(dayData.total_vendido).toFixed(2)"></span></p>
                                            </div>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Efectivo</p>
                                                <p class="font-bold text-gray-800" x-text="'RD$ ' + Number(dayData.total_efectivo).toFixed(2)"></p>
                                            </div>
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Boucher</p>
                                                <p class="font-bold text-gray-800" x-text="'RD$ ' + Number(dayData.total_boucher).toFixed(2)"></p>
                                            </div>
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Crédito</p>
                                                <p class="font-bold text-gray-800" x-text="'RD$ ' + Number(dayData.total_credito).toFixed(2)"></p>
                                            </div>
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Monedas</p>
                                                <p class="font-bold text-gray-800" x-text="'RD$ ' + Number(dayData.total_moneda).toFixed(2)"></p>
                                            </div>
                                            
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Ingresos</p>
                                                <p class="font-bold text-blue-600" x-text="'RD$ ' + Number(dayData.total_ingresos).toFixed(2)"></p>
                                            </div>
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100">
                                                <p class="text-xs text-gray-500">Total Gastos</p>
                                                <p class="font-bold text-red-600" x-text="'RD$ ' + Number(dayData.total_gastos).toFixed(2)"></p>
                                            </div>
                                            <div class="bg-white p-3 rounded shadow-sm border border-emerald-100 md:col-span-2">
                                                <p class="text-xs text-gray-500">Diferencia Final</p>
                                                <p class="font-bold" :class="{'text-emerald-600': dayData.diferencia_general >= 0, 'text-red-600': dayData.diferencia_general < 0}" x-text="(dayData.diferencia_general < 0 ? '-' : '') + 'RD$ ' + Math.abs(dayData.diferencia_general).toFixed(2)"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TOTALES POR COMBUSTIBLE -->
                                    <div class="rounded-xl border border-blue-200 bg-blue-50 p-6 shadow-sm">
                                        <p class="text-sm font-bold text-blue-700 uppercase tracking-widest mb-4">Totales por Combustible</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <template x-for="(total, combustible) in dayData.totales_combustibles" :key="combustible">
                                                <div class="bg-white p-4 rounded-lg shadow-sm border border-blue-100 text-center">
                                                    <p class="text-xs text-gray-500 font-medium mb-1" x-text="combustible"></p>
                                                    <p class="font-bold text-blue-700 text-lg" x-text="'$' + Number(total).toFixed(2)"></p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                        <button type="button" @click="modalOpen = false" class="mt-3 inline-flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
