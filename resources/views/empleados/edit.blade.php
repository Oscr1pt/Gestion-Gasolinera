<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Empleado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('empleados.update', $empleado) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nombre -->
                            <div>
                                <x-input-label for="nombre" :value="__('Nombre Completo')" />
                                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $empleado->nombre)" required autofocus />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <!-- Cédula -->
                            <div>
                                <x-input-label for="cedula" :value="__('Cédula')" />
                                <x-text-input id="cedula" class="block mt-1 w-full" type="text" name="cedula" :value="old('cedula', $empleado->cedula)" required />
                                <x-input-error :messages="$errors->get('cedula')" class="mt-2" />
                            </div>

                            <!-- Teléfono -->
                            <div>
                                <x-input-label for="telefono" :value="__('Teléfono')" />
                                <x-text-input id="telefono" class="block mt-1 w-full" type="text" name="telefono" :value="old('telefono', $empleado->telefono)" required />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>

                            <!-- Posición -->
                            <div>
                                <x-input-label for="posicion" :value="__('Posición')" />
                                <x-text-input id="posicion" class="block mt-1 w-full" type="text" name="posicion" :value="old('posicion', $empleado->posicion)" required />
                                <x-input-error :messages="$errors->get('posicion')" class="mt-2" />
                            </div>

                            <!-- Dirección -->
                            <div class="md:col-span-2">
                                <x-input-label for="direccion" :value="__('Dirección')" />
                                <textarea id="direccion" name="direccion" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="3" required>{{ old('direccion', $empleado->direccion) }}</textarea>
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <!-- Fecha Inicio -->
                            <div>
                                <x-input-label for="fecha_inicio" :value="__('Fecha de Inicio')" />
                                <x-text-input id="fecha_inicio" class="block mt-1 w-full" type="date" name="fecha_inicio" :value="old('fecha_inicio', $empleado->fecha_inicio)" required />
                                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                            </div>

                            <!-- Fecha Terminación -->
                            <div>
                                <x-input-label for="fecha_terminacion" :value="__('Fecha de Terminación (Opcional)')" />
                                <x-text-input id="fecha_terminacion" class="block mt-1 w-full" type="date" name="fecha_terminacion" :value="old('fecha_terminacion', $empleado->fecha_terminacion)" />
                                <x-input-error :messages="$errors->get('fecha_terminacion')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-sm text-gray-500">
                                    Estado actual: <strong>{{ $empleado->estado }}</strong>.
                                    Se actualiza automáticamente según la fecha de terminación.
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('empleados.index') }}">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button class="ml-4">
                                {{ __('Actualizar Empleado') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
