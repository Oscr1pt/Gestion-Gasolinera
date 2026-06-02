<x-app-layout>
    <x-slot name="header">{{ __('Dispensadores') }}</x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="flex flex-col gap-4 border-b border-gray-100 p-6 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Dispensadores</h2>
                    <p class="mt-1 text-sm text-gray-500">Gestión de estaciones de servicio</p>
                </div>
                <a href="{{ route('dispensadores.create') }}" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Nuevo dispensador
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">ID</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Nombre</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Lados</th>
                            <th class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Mangueras</th>
                            <th class="px-6 py-3.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($dispensadores as $dispensador)
                            <tr class="hover:bg-slate-50/60">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">#{{ $dispensador->id }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $dispensador->nombre }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $dispensador->lados_count ?? $dispensador->lados->count() }} lados</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $dispensador->mangueras_count ?? $dispensador->lados->sum(fn($lado) => $lado->mangueras->count()) }} mangueras</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <a href="{{ route('dispensadores.show', $dispensador) }}" class="inline-flex rounded-lg bg-indigo-50 p-2 text-indigo-600 hover:bg-indigo-100" title="Ver detalles">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ route('dispensadores.edit', $dispensador) }}" class="ml-2 inline-flex rounded-lg bg-blue-50 p-2 text-blue-600 hover:bg-blue-100" title="Editar">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>
                                    <form method="POST" action="{{ route('dispensadores.destroy', $dispensador) }}" class="ml-2 inline" onsubmit="return confirm('¿Estás seguro de eliminar este dispensador y todos sus lados y mangueras?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex rounded-lg bg-red-50 p-2 text-red-600 hover:bg-red-100" title="Eliminar">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                    No hay dispensadores registrados.
                                    <a href="{{ route('dispensadores.create') }}" class="font-semibold text-blue-600 hover:underline">Registrar el primero</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($dispensadores->hasPages())
                <div class="border-t border-gray-100 px-6 py-4">
                    {{ $dispensadores->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
