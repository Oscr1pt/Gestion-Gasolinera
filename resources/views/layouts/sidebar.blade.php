@php
    $navLink = fn (bool $active) => $active
        ? 'bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg shadow-blue-900/40'
        : 'text-slate-300 hover:bg-white/10 hover:text-white';
    $navIcon = fn (bool $active) => $active ? 'text-white' : 'text-slate-400 group-hover:text-white';
@endphp

<div
    :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed inset-y-0 left-0 z-30 flex h-full w-[260px] flex-col overflow-y-auto bg-gradient-to-b from-[#0c1524] via-[#101d33] to-[#152a47] shadow-xl transition duration-300 lg:static lg:inset-0 lg:translate-x-0"
>
    <div class="mb-6 mt-8 flex items-center justify-center px-4">
        <div class="flex items-center gap-2.5">
            <div class="text-orange-500">
                <svg class="h-9 w-9" fill="currentColor" viewBox="0 0 24 24"><path d="M19.5 8.5C18.1 8.5 17 9.6 17 11v6c0 .6-.4 1-1 1s-1-.4-1-1v-8C15 6.2 12.8 4 10 4H6C3.2 4 1 6.2 1 9v11h2v-5h8v5h2V9c0-1.7 1.3-3 3-3s3 1.3 3 3v2.5c0 1.1-.9 2-2 2h-1v-2h-1v2.5c0 1.9 1.6 3.5 3.5 3.5S22 15.4 22 13.5V11c0-1.4-1.1-2.5-2.5-2.5zM12 13H4V9c0-.6.4-1 1-1h6c.6 0 1 .4 1 1v4z"/></svg>
            </div>
            <div>
                <span class="block text-lg font-bold leading-none tracking-wide text-white uppercase">{{ $generales_config['nombre_empresa']->valor ?? 'GASOLINERA' }}</span>
                <span class="mt-1 block text-sm font-semibold tracking-[0.2em] text-orange-500 uppercase">{{ $generales_config['nombre_sistema']->valor ?? 'CONTROL' }}</span>
            </div>
        </div>
    </div>

    <div class="px-4">
        <a
            href="{{ route('dashboard') }}"
            class="group mt-2 flex items-center rounded-xl px-4 py-3 text-sm font-medium transition-all {{ $navLink(request()->routeIs('dashboard')) }}"
        >
            <svg class="{{ $navIcon(request()->routeIs('dashboard')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            Dashboard
        </a>
    </div>

    <nav class="mt-5 flex-1 px-4 text-sm font-medium">
        <p class="mb-2 ml-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">Gestión</p>

        <a href="{{ route('empleados.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('empleados.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('empleados.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Empleados
        </a>

        <a href="{{ route('dispensadores.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('dispensadores.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('dispensadores.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            Dispensadores
        </a>

        <a href="{{ route('turnos.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('turnos.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('turnos.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Turnos
        </a>

        @foreach([
            ['label' => 'Ventas', 'icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'route' => null],
            ['label' => 'Reportes', 'icon' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z', 'route' => null],
        ] as $item)
            <a href="#" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 text-slate-300 transition-all hover:bg-white/10 hover:text-white">
                <svg class="mr-3 h-5 w-5 text-slate-400 group-hover:text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                </svg>
                {{ $item['label'] }}
            </a>
        @endforeach

        <a href="{{ route('cuadres.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('cuadres.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('cuadres.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Cuadres
        </a>

        <p class="mb-2 ml-2 mt-6 text-[10px] font-bold uppercase tracking-widest text-slate-500">Sistema</p>

        <a href="{{ route('users.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('users.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('users.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            Usuarios
        </a>

        <a href="{{ route('configuracion.index') }}" class="group mb-1 flex items-center rounded-lg px-4 py-2.5 transition-all {{ $navLink(request()->routeIs('configuracion.*')) }}">
            <svg class="{{ $navIcon(request()->routeIs('configuracion.*')) }} mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            Configuración
        </a>
    </nav>

    <div class="mt-auto px-4 pb-6">
        <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-gradient-to-br from-[#1e3358] to-[#152238] p-4 text-white shadow-xl">
            <div class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-blue-400/20 blur-2xl"></div>
            <div class="relative flex items-center justify-between">
                <span class="text-[10px] font-bold uppercase tracking-wider text-slate-400">Turno actual</span>
                <span id="turno-estado" class="rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-400">Activo</span>
            </div>
            <h4 id="turno-nombre" class="relative mt-3 text-sm font-bold">Turno Matutino</h4>
            <p id="turno-horario" class="relative mt-1 text-[11px] text-slate-400">06:00 AM — 02:00 PM</p>
            <p class="relative mt-3 flex items-center text-[11px] text-slate-300">
                <svg class="mr-1.5 h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Estación Central
            </p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Horarios desde BD, fallback a valores por defecto si no existen
            const matutinoInicioStr = '{{ $turnos_config["matutino"]->hora_inicio ?? "06:00:00" }}';
            const matutinoFinStr = '{{ $turnos_config["matutino"]->hora_fin ?? "14:00:00" }}';
            const nocturnoInicioStr = '{{ $turnos_config["nocturno"]->hora_inicio ?? "14:00:00" }}';
            const nocturnoFinStr = '{{ $turnos_config["nocturno"]->hora_fin ?? "06:00:00" }}';

            function parseTime(timeStr) {
                const [hours, minutes] = timeStr.split(':').map(Number);
                return hours * 60 + minutes; // Convert to minutes since midnight
            }

            function formatTime(timeStr) {
                const [hours, minutes] = timeStr.split(':').map(Number);
                const ampm = hours >= 12 ? 'PM' : 'AM';
                let h = hours % 12;
                h = h ? h : 12;
                return `${h.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} ${ampm}`;
            }

            const now = new Date();
            const currentMinutes = now.getHours() * 60 + now.getMinutes();

            const matutinoInicio = parseTime(matutinoInicioStr);
            const matutinoFin = parseTime(matutinoFinStr);
            const nocturnoInicio = parseTime(nocturnoInicioStr);
            const nocturnoFin = parseTime(nocturnoFinStr);

            const turnoNombre = document.getElementById('turno-nombre');
            const turnoHorario = document.getElementById('turno-horario');
            const turnoEstado = document.getElementById('turno-estado');

            function isBetween(current, start, end) {
                if (start <= end) {
                    return current >= start && current < end;
                } else {
                    // Crosses midnight
                    return current >= start || current < end;
                }
            }

            if (turnoNombre && turnoHorario && turnoEstado) {
                if (isBetween(currentMinutes, matutinoInicio, matutinoFin)) {
                    turnoNombre.textContent = 'Turno Matutino';
                    turnoHorario.textContent = `${formatTime(matutinoInicioStr)} — ${formatTime(matutinoFinStr)}`;
                    turnoEstado.textContent = 'Activo';
                    turnoEstado.className = 'rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-400';
                } else if (isBetween(currentMinutes, nocturnoInicio, nocturnoFin)) {
                    turnoNombre.textContent = 'Turno Nocturno';
                    turnoHorario.textContent = `${formatTime(nocturnoInicioStr)} — ${formatTime(nocturnoFinStr)}`;
                    turnoEstado.textContent = 'Activo';
                    turnoEstado.className = 'rounded-full bg-emerald-500/20 px-2 py-0.5 text-[10px] font-bold text-emerald-400';
                } else {
                    turnoNombre.textContent = 'Fuera de Turno';
                    turnoHorario.textContent = '—';
                    turnoEstado.textContent = 'Inactivo';
                    turnoEstado.className = 'rounded-full bg-red-500/20 px-2 py-0.5 text-[10px] font-bold text-red-400';
                }
            }
        });
    </script>
</div>
