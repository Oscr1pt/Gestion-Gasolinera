<x-app-layout>
    <x-slot name="header">
        {{ __('Dashboard') }}
    </x-slot>

    <div class="space-y-6">
        {{-- KPIs --}}
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">
            <x-dashboard.kpi-card
                title="Empleados Activos"
                :value="$kpis['empleados_activos']"
                :trend="$kpis['empleados_trend'] ?? '+2 este mes'"
                icon-bg="bg-blue-500"
                icon-shadow="shadow-blue-500/30"
            >
                <x-slot name="icon">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </x-slot>
            </x-dashboard.kpi-card>



            <x-dashboard.kpi-card
                title="Dispensadoras"
                :value="$kpis['dispensadoras']"
                hint="Operativas"
                icon-bg="bg-orange-500"
                icon-shadow="shadow-orange-500/30"
            >
                <x-slot name="icon">
                    <svg class="h-7 w-7" fill="currentColor" viewBox="0 0 24 24"><path d="M19.5 8.5C18.1 8.5 17 9.6 17 11v6c0 .6-.4 1-1 1s-1-.4-1-1v-8C15 6.2 12.8 4 10 4H6C3.2 4 1 6.2 1 9v11h2v-5h8v5h2V9c0-1.7 1.3-3 3-3s3 1.3 3 3v2.5c0 1.1-.9 2-2 2h-1v-2h-1v2.5c0 1.9 1.6 3.5 3.5 3.5S22 15.4 22 13.5V11c0-1.4-1.1-2.5-2.5-2.5zM12 13H4V9c0-.6.4-1 1-1h6c.6 0 1 .4 1 1v4z"/></svg>
                </x-slot>
            </x-dashboard.kpi-card>

            <x-dashboard.kpi-card
                title="Ventas (Gasolina)"
                :value="'$' . number_format($kpis['ventas_combustible'] ?? 0, 2)"
                icon-bg="bg-indigo-600"
                icon-shadow="shadow-indigo-600/30"
            >
                <x-slot name="icon">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </x-slot>
                <x-slot name="trend">
                    <span class="text-xs font-medium text-gray-500">Combustibles hoy</span>
                </x-slot>
            </x-dashboard.kpi-card>

            <x-dashboard.kpi-card
                title="Ventas (Tienda)"
                :value="'$' . number_format($kpis['ventas_tienda'] ?? 0, 2)"
                icon-bg="bg-emerald-500"
                icon-shadow="shadow-emerald-500/30"
            >
                <x-slot name="icon">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </x-slot>
                <x-slot name="trend">
                    <span class="text-xs font-medium text-emerald-600">Total: ${{ number_format($kpis['ventas_totales'] ?? 0, 2) }}</span>
                </x-slot>
            </x-dashboard.kpi-card>


        </div>

        {{-- Estado de Tanques --}}
        <div>
            <h3 class="text-lg font-bold text-gray-900 mb-4">Estado de Tanques</h3>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($tanques as $tanque)
                    @php
                        $porcentaje = $tanque->capacidad_maxima > 0 ? ($tanque->existencia_actual / $tanque->capacidad_maxima) * 100 : 0;
                        $color = $porcentaje > 50 ? 'bg-emerald-500' : ($porcentaje > 20 ? 'bg-yellow-500' : 'bg-red-500');
                    @endphp
                    <div class="rounded-xl border border-gray-100 bg-white p-4 shadow-sm">
                        <div class="mb-2 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $tanque->nombre }}</p>
                                <p class="text-xs text-gray-500">{{ $tanque->tipoCombustible->nombre ?? 'N/A' }}</p>
                            </div>
                            <span class="text-sm font-bold {{ $porcentaje < 20 ? 'text-red-600' : 'text-gray-700' }}">{{ number_format($porcentaje, 1) }}%</span>
                        </div>
                        <div class="w-full overflow-hidden rounded-full bg-gray-200">
                            <div class="h-2 rounded-full {{ $color }}" style="width: {{ $porcentaje }}%"></div>
                        </div>
                        <p class="mt-2 text-right text-xs text-gray-500">
                            {{ number_format($tanque->existencia_actual, 2) }} / {{ number_format($tanque->capacidad_maxima, 2) }} gal
                        </p>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Gráficos --}}
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
            <x-dashboard.chart-card
                title="Ventas por día"
                subtitle="Últimos 7 días"
                class="lg:col-span-8"
            >
                <x-slot name="actions">
                    <select class="rounded-lg border-gray-200 bg-gray-50 py-1.5 pl-3 pr-8 text-sm text-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option>Semana</option>
                        <option>Mes</option>
                    </select>
                </x-slot>
                <div class="relative h-72 w-full">
                    <canvas id="lineChartVentas"></canvas>
                </div>
            </x-dashboard.chart-card>

            <x-dashboard.chart-card
                title="Distribución de turnos"
                subtitle="Participación por turno"
                class="lg:col-span-4"
            >
                <div class="relative mx-auto h-64 w-full max-w-xs">
                    <canvas id="pieChartTurnos"></canvas>
                </div>
                <div class="mt-4 space-y-2">
                    @foreach($chartDistribucionTurnos['labels'] as $index => $label)
                        @php
                            $colors = ['bg-blue-500', 'bg-emerald-500', 'bg-amber-400'];
                            $pct = $chartDistribucionTurnos['data'][$index];
                        @endphp
                        <div class="flex items-center justify-between text-sm">
                            <span class="flex items-center gap-2 text-gray-600">
                                <span class="h-2.5 w-2.5 rounded-full {{ $colors[$index] ?? 'bg-gray-400' }}"></span>
                                {{ $label }}
                            </span>
                            <span class="font-semibold text-gray-800">{{ $pct }}%</span>
                        </div>
                    @endforeach
                </div>
            </x-dashboard.chart-card>
        </div>

        <x-dashboard.chart-card
            title="Rendimiento de empleados"
            subtitle="Índice de desempeño semanal (%)"
        >
            <x-slot name="actions">
                <select class="rounded-lg border-gray-200 bg-gray-50 py-1.5 pl-3 pr-8 text-sm text-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option>Esta semana</option>
                    <option>Mes anterior</option>
                </select>
            </x-slot>
            <div class="relative h-80 w-full">
                <canvas id="barChartEmpleados"></canvas>
            </div>
        </x-dashboard.chart-card>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartDefaults = {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                };

                const ventas = @json($chartVentasDia);
                const lineCtx = document.getElementById('lineChartVentas').getContext('2d');
                const gradient = lineCtx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, 'rgba(59, 130, 246, 0.25)');
                gradient.addColorStop(1, 'rgba(59, 130, 246, 0)');

                new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: ventas.labels,
                        datasets: [{
                            label: 'Ventas',
                            data: ventas.data,
                            borderColor: '#3b82f6',
                            backgroundColor: gradient,
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#3b82f6',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.35,
                        }],
                    },
                    options: {
                        ...chartDefaults,
                        scales: {
                            y: {
                                beginAtZero: true,
                                border: { display: false },
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    color: '#94a3b8',
                                    font: { size: 11 },
                                    callback: (v) => v === 0 ? '$0' : '$' + (v / 1000) + 'k',
                                },
                            },
                            x: {
                                border: { display: false },
                                grid: { display: false },
                                ticks: { color: '#94a3b8', font: { size: 11 } },
                            },
                        },
                    },
                });

                const turnos = @json($chartDistribucionTurnos);
                new Chart(document.getElementById('pieChartTurnos'), {
                    type: 'pie',
                    data: {
                        labels: turnos.labels,
                        datasets: [{
                            data: turnos.data,
                            backgroundColor: ['#3b82f6', '#10b981', '#fbbf24'],
                            borderWidth: 0,
                            hoverOffset: 6,
                        }],
                    },
                    options: {
                        ...chartDefaults,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => ' ' + ctx.label + ': ' + ctx.raw + '%',
                                },
                            },
                        },
                    },
                });

                const empleados = @json($chartRendimientoEmpleados);
                new Chart(document.getElementById('barChartEmpleados'), {
                    type: 'bar',
                    data: {
                        labels: empleados.labels,
                        datasets: [{
                            label: 'Rendimiento %',
                            data: empleados.data,
                            backgroundColor: '#3b82f6',
                            hoverBackgroundColor: '#2563eb',
                            borderRadius: 8,
                            barPercentage: 0.55,
                        }],
                    },
                    options: {
                        ...chartDefaults,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: 100,
                                border: { display: false },
                                grid: { color: '#f1f5f9' },
                                ticks: {
                                    color: '#94a3b8',
                                    font: { size: 11 },
                                    callback: (v) => v + '%',
                                },
                            },
                            x: {
                                border: { display: false },
                                grid: { display: false },
                                ticks: {
                                    color: '#64748b',
                                    font: { size: 11 },
                                    maxRotation: 45,
                                    minRotation: 0,
                                },
                            },
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) => ' ' + ctx.raw + '%',
                                },
                            },
                        },
                    },
                });
            });
        </script>
    @endpush
</x-app-layout>
