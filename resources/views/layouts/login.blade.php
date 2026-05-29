<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Iniciar sesión — Gestión Gasolinera</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen font-sans antialiased" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-[#0a1628] via-[#0f2744] to-[#1d4ed8] px-4 py-10">
            {{-- Círculos decorativos --}}
            <div class="pointer-events-none absolute -right-32 top-1/4 h-[500px] w-[500px] rounded-full border border-white/5"></div>
            <div class="pointer-events-none absolute -right-16 top-1/3 h-[380px] w-[380px] rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute right-8 top-[38%] h-[260px] w-[260px] rounded-full border border-white/5"></div>

            {{-- Imagen gasolinera + marca inferior izquierda --}}
            <div class="pointer-events-none absolute bottom-0 left-0 z-0 hidden w-full max-w-xl lg:block">
                <div class="relative h-72 w-full">
                    <img
                        src="https://images.unsplash.com/photo-1574269909862-763725994b8f?auto=format&fit=crop&w=900&q=80"
                        alt=""
                        class="h-full w-full object-cover object-left opacity-40 mix-blend-luminosity"
                        loading="lazy"
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a1628] via-[#0a1628]/60 to-transparent"></div>
                    <div class="absolute bottom-8 left-10 flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/10 backdrop-blur-sm">
                            <svg class="h-7 w-7 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.5 8.5C18.1 8.5 17 9.6 17 11v6c0 .6-.4 1-1 1s-1-.4-1-1v-8C15 6.2 12.8 4 10 4H6C3.2 4 1 6.2 1 9v11h2v-5h8v5h2V9c0-1.7 1.3-3 3-3s3 1.3 3 3v2.5c0 1.1-.9 2-2 2h-1v-2h-1v2.5c0 1.9 1.6 3.5 3.5 3.5S22 15.4 22 13.5V11c0-1.4-1.1-2.5-2.5-2.5zM12 13H4V9c0-.6.4-1 1-1h6c.6 0 1 .4 1 1v4z"/></svg>
                        </div>
                        <div>
                            <p class="text-lg font-bold tracking-wide text-white">GESTIÓN</p>
                            <p class="text-sm font-semibold tracking-[0.25em] text-orange-400">GASOLINERA</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Card login --}}
            <div class="relative z-10 w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
