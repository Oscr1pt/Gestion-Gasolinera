<x-app-layout>
    <x-slot name="header">{{ __('Editar dispensador') }}</x-slot>

    <div class="mx-auto max-w-6xl space-y-6">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900">Editar dispensador: {{ $dispensador->nombre }}</h2>
                <p class="mt-1 text-sm text-gray-500">Habilita o inhabilita lados y mangueras individuales</p>
            </div>

            <form id="form-dispensador" method="POST" action="{{ route('dispensadores.update', $dispensador) }}" class="p-6 pb-0">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <x-input-label for="nombre" value="Nombre del dispensador" />
                    <x-text-input id="nombre" class="mt-1 block w-full" type="text" name="nombre" :value="old('nombre', $dispensador->nombre)" required autofocus />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

            <div class="px-6 pb-6">
                <div class="mb-8 border-t border-gray-100 pt-6">
                    <h3 class="mb-4 text-sm font-bold uppercase tracking-wider text-gray-500">Lados y Mangueras</h3>
                    
                    <div class="space-y-6">
                        @foreach($dispensador->lados as $lado)
                            <div class="rounded-2xl border border-gray-200 bg-slate-50 p-5">
                                <div class="mb-4 flex items-center justify-between">
                                    <h4 class="text-lg font-bold text-gray-900">{{ $lado->nombre }}</h4>
                                    <div class="inline">
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="hidden" name="lados[{{ $lado->id }}][habilitado]" value="0">
                                            <input type="checkbox" name="lados[{{ $lado->id }}][habilitado]" value="1" {{ $lado->habilitado ? 'checked' : '' }} class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm font-medium {{ $lado->habilitado ? 'text-emerald-600' : 'text-red-600' }}">
                                                {{ $lado->habilitado ? 'Habilitado' : 'Inhabilitado' }}
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                
                                @if($lado->habilitado)
                                    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">
                                        @foreach($lado->mangueras as $manguera)
                                            <div class="rounded-lg border border-gray-200 bg-white p-3">
                                                <div class="flex items-center justify-between mb-2">
                                                    <span class="text-sm font-semibold text-gray-900">Manguera {{ $manguera->numero }}</span>
                                                    <div class="inline">
                                                        <label class="flex items-center gap-2 cursor-pointer">
                                                            <input type="hidden" name="mangueras[{{ $manguera->id }}][habilitado]" value="0">
                                                            <input type="checkbox" name="mangueras[{{ $manguera->id }}][habilitado]" value="1" {{ $manguera->habilitado ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                            <span class="text-xs {{ $manguera->habilitado ? 'text-emerald-600' : 'text-red-600' }}">
                                                                {{ $manguera->habilitado ? 'Activa' : 'Inactiva' }}
                                                            </span>
                                                        </label>
                                                    </div>
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

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('dispensadores.show', $dispensador) }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Guardar cambios
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</x-app-layout>
