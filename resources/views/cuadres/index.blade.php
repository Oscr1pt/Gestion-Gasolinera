<x-app-layout>
    <x-slot name="header">{{ __('Cuadres') }}</x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="flex flex-col gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Cuadres</h2>
                    <p class="mt-1 text-sm text-gray-500">Registro y consulta de cuadres por dispensador</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center gap-3">
                    <form method="GET" action="{{ route('cuadres.index') }}" class="flex items-center gap-2">
                        <input type="date" name="fecha" value="{{ request('fecha') }}" class="rounded-lg border-gray-200 text-sm focus:border-blue-500 focus:ring-blue-500" title="Buscar por fecha">
                        <button type="submit" class="rounded-lg bg-gray-100 px-3 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-200">
                            Buscar
                        </button>
                        @if(request('fecha'))
                            <a href="{{ route('cuadres.index') }}" class="text-xs font-medium text-red-500 hover:text-red-700">Limpiar</a>
                        @endif
                    </form>

                    <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('cuadres.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nuevo Cuadre
            </a>
        </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">ID</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Dispensador</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Turno</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Fecha</th>
                            <th class="px-6 py-3.5 text-right text-[11px] font-bold uppercase tracking-wider text-gray-500">Total</th>
                            <th class="px-6 py-3.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($cuadres as $cuadre)
                            <tr class="hover:bg-slate-50/60">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">#{{ $cuadre->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $cuadre->dispensador->nombre }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                        {{ $cuadre->turno ? $cuadre->turno->nombre : 'N/A' }}
                                    </span>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $cuadre->created_at->format('d/m/Y H:i') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-semibold text-gray-900">${{ number_format($cuadre->total, 2) }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <a href="{{ route('cuadres.show', $cuadre) }}" class="inline-flex rounded-lg bg-indigo-50 p-2 text-indigo-600 hover:bg-indigo-100" title="Ver resumen">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('cuadres.destroy', $cuadre) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de ELIMINAR permanentemente este cuadre?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex rounded-lg bg-red-50 p-2 text-red-500 transition hover:bg-red-100 hover:text-red-700" title="Eliminar">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No hay cuadres registrados.
                                    <a href="{{ route('cuadres.create') }}" class="font-semibold text-blue-600 hover:underline">Registrar el primero</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($cuadres->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $cuadres->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
