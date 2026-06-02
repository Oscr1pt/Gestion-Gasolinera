<x-app-layout>
    <x-slot name="header">{{ __('Detalle de dispensador') }}</x-slot>

    <div class="mx-auto max-w-6xl space-y-6">
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800" role="alert">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900">Dispensador #{{ $dispensador->id }}</h2>
                <p class="mt-1 text-sm text-gray-500">{{ $dispensador->nombre }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('dispensadores.edit', $dispensador) }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    Editar
                </a>
                <form method="POST" action="{{ route('dispensadores.destroy', $dispensador) }}" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este dispensador y todos sus lados y mangueras?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                        Eliminar
                    </button>
                </form>
                <a href="{{ route('dispensadores.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50">
                    Volver al listado
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div class="rounded-2xl border border-blue-100 bg-gradient-to-br from-blue-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-blue-600">Lados</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $dispensador->lados->count() }}</p>
                <p class="mt-1 text-xs text-gray-500">Total de lados</p>
            </div>
            <div class="rounded-2xl border border-emerald-100 bg-gradient-to-br from-emerald-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-emerald-600">Mangueras</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $dispensador->lados->sum(fn($lado) => $lado->mangueras->count()) }}</p>
                <p class="mt-1 text-xs text-gray-500">Total de mangueras</p>
            </div>
            <div class="rounded-2xl border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white p-6 shadow-sm">
                <p class="text-sm font-medium text-indigo-600">Habilitadas</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">{{ $dispensador->lados->sum(fn($lado) => $lado->mangueras->where('habilitado', true)->count()) }}</p>
                <p class="mt-1 text-xs text-gray-500">Mangueras activas</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 px-6 py-4">
                <h3 class="font-bold text-gray-800">Estructura del dispensador</h3>
            </div>
            <div class="divide-y divide-gray-50">
                @foreach($dispensador->lados as $lado)
                    <div class="px-6 py-4">
                        <div class="mb-3 flex items-center justify-between">
                            <h4 class="text-lg font-bold text-gray-900">{{ $lado->nombre }}</h4>
                            <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $lado->habilitado ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                {{ $lado->habilitado ? 'Habilitado' : 'Inhabilitado' }}
                            </span>
                        </div>
                        @if($lado->habilitado)
                            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                @foreach($lado->mangueras as $manguera)
                                    <div class="rounded-lg border border-gray-200 bg-slate-50 p-3">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-sm font-semibold text-gray-900">Manguera {{ $manguera->numero }}</span>
                                            <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $manguera->habilitado ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                {{ $manguera->habilitado ? 'Activa' : 'Inactiva' }}
                                            </span>
                                        </div>
                                        <div class="h-2 rounded-full {{ $manguera->habilitado ? 'bg-emerald-500' : 'bg-red-500' }}"></div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 italic">Este lado está inhabilitado. Sus mangueras no están disponibles.</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
