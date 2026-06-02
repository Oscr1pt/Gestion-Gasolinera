<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detalle de Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center gap-6 mb-8">
                        <img
                            class="h-24 w-24 rounded-full object-cover shadow-lg"
                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&bold=true&size=128"
                            alt="{{ $user->name }}"
                        />
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                            <p class="text-gray-500">{{ $user->email }}</p>
                            @if($user->estado)
                                <span class="inline-flex mt-2 rounded-full bg-emerald-100 px-3 py-1 text-sm font-bold text-emerald-700">Activo</span>
                            @else
                                <span class="inline-flex mt-2 rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-700">Inactivo</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-slate-50 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Correo Electrónico</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->email }}</p>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Teléfono</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->telefono }}</p>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Estado</p>
                            <p class="text-lg font-semibold text-gray-900">
                                @if($user->estado)
                                    <span class="text-emerald-600">Activo</span>
                                @else
                                    <span class="text-red-600">Inactivo</span>
                                @endif
                            </p>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Fecha de Registro</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div class="bg-slate-50 rounded-xl p-5">
                            <p class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2">Última Actualización</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-8 gap-3">
                        <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Editar Usuario
                        </a>
                        <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
