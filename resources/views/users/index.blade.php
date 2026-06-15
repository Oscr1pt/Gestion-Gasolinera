<x-app-layout>
    <x-slot name="header">
        {{ __('Usuarios') }}
    </x-slot>

    <div class="space-y-6">
        @if (session('success'))
            <div class="relative rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-800 shadow-sm" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-[0_1px_3px_rgba(0,0,0,0.06)]">
            <div class="flex flex-col gap-4 border-b border-gray-100 p-6 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Usuarios</h2>
                    <p class="mt-1 text-sm text-gray-500">Gestiona los usuarios del sistema</p>
                </div>
                <div class="flex w-full flex-col gap-3 sm:flex-row sm:items-center md:w-auto">
                    <form method="GET" action="{{ route('users.index') }}" class="relative w-full sm:w-72">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input
                            type="text"
                            name="search"
                            value="{{ $search ?? request('search') }}"
                            placeholder="Buscar usuario..."
                            class="block w-full rounded-xl border border-gray-200 bg-gray-50 py-2.5 pl-10 pr-3 text-sm text-gray-800 placeholder-gray-400 transition focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-500/20"
                        />
                    </form>
                    <a
                        href="{{ route('users.create') }}"
                        class="inline-flex items-center justify-center gap-1.5 whitespace-nowrap rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-blue-500/30 transition hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Agregar Usuario
                    </a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-100">
                    <thead>
                        <tr class="bg-slate-50/80">
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Nombre</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Email</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Rol</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Teléfono</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Estado</th>
                            <th scope="col" class="px-6 py-3.5 text-left text-[11px] font-bold uppercase tracking-wider text-gray-500">Fecha de creación</th>
                            <th scope="col" class="px-6 py-3.5 text-center text-[11px] font-bold uppercase tracking-wider text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 bg-white">
                        @forelse($users as $user)
                            <tr class="transition-colors hover:bg-slate-50/60">
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img
                                            class="h-9 w-9 rounded-full object-cover shadow-sm"
                                            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=2563eb&color=fff&bold=true&size=64"
                                            alt="{{ $user->name }}"
                                        />
                                        <span class="text-sm font-semibold text-gray-900">{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">
                                    @if($user->role === 'admin')
                                        <span class="inline-flex rounded-full bg-purple-100 px-2.5 py-1 text-[11px] font-bold text-purple-700">Admin</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[11px] font-bold text-blue-700">Usuario</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->telefono }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    @if($user->estado)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-bold text-emerald-700">Activo</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-[11px] font-bold text-red-700">Inactivo</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-center">
                                    <div class="inline-flex items-center justify-center gap-1.5">
                                        <a href="{{ route('users.show', $user) }}" class="rounded-lg bg-indigo-50 p-2 text-indigo-500 transition hover:bg-indigo-100 hover:text-indigo-700" title="Ver">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('users.edit', $user) }}" class="rounded-lg bg-blue-50 p-2 text-blue-500 transition hover:bg-blue-100 hover:text-blue-700" title="Editar">
                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                        </a>
                                        @if(auth()->user()->role === 'admin' || $user->role !== 'admin')
                                        <form action="{{ route('users.disable', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de desactivar este usuario?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="rounded-lg bg-orange-50 p-2 text-orange-500 transition hover:bg-orange-100 hover:text-orange-700" title="Desactivar">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            </button>
                                        </form>
                                        @endif
                                        @if(auth()->user()->role === 'admin')
                                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de ELIMINAR permanentemente este usuario?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-lg bg-red-50 p-2 text-red-500 transition hover:bg-red-100 hover:text-red-700" title="Eliminar">
                                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">
                                    @if(request('search'))
                                        No se encontraron usuarios para "{{ request('search') }}".
                                    @else
                                        No hay usuarios registrados. <a href="{{ route('users.create') }}" class="font-semibold text-blue-600 hover:underline">Agregar el primero</a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages() || $users->total() > 0)
                <div class="flex flex-col items-center justify-between gap-3 border-t border-gray-100 px-6 py-4 sm:flex-row">
                    <p class="text-sm text-gray-500">
                        Mostrando {{ $users->firstItem() ?? 0 }} a {{ $users->lastItem() ?? 0 }} de {{ $users->total() }} usuarios
                    </p>
                    <div>
                        {{ $users->links('pagination::tailwind') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
