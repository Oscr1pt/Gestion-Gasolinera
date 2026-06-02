<x-app-layout>
    <x-slot name="header">{{ __('Nuevo dispensador') }}</x-slot>

    <div class="mx-auto max-w-4xl">
        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="border-b border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-900">Crear dispensador</h2>
                <p class="mt-1 text-sm text-gray-500">Se crearán automáticamente 2 lados (A y B) con 4 mangueras cada uno</p>
            </div>

            <form method="POST" action="{{ route('dispensadores.store') }}" class="p-6">
                @csrf

                <div class="mb-6">
                    <x-input-label for="nombre" value="Nombre del dispensador" />
                    <x-text-input id="nombre" class="mt-1 block w-full" type="text" name="nombre" :value="old('nombre')" placeholder="Ej: Estación 1" required autofocus />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div class="mb-6 rounded-xl border border-blue-100 bg-blue-50 p-4">
                    <h3 class="text-sm font-bold text-blue-900">Estructura que se creará automáticamente:</h3>
                    <ul class="mt-2 text-sm text-blue-700">
                        <li>• 2 lados: Lado A y Lado B</li>
                        <li>• 4 mangueras por lado (total 8 mangueras)</li>
                        <li>• Todos los elementos habilitados por defecto</li>
                    </ul>
                </div>

                <div class="flex items-center justify-end gap-3 border-t border-gray-100 pt-6">
                    <a href="{{ route('dispensadores.index') }}" class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 hover:bg-blue-700">
                        Crear dispensador
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
