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
        <div
            class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800 px-4 py-10"
        >
            {{-- Decorative gas station image in bottom-left corner --}}
            <img
                src="/images/gasolinera.png"
                class="absolute bottom-0 left-0 w-[400px] opacity-20 blur-sm pointer-events-none select-none z-0"
                alt=""
            />

            {{-- Círculos decorativos (mockup) --}}
            <div class="pointer-events-none absolute -right-32 top-1/4 z-[1] h-[500px] w-[500px] rounded-full border border-white/5"></div>
            <div class="pointer-events-none absolute -right-16 top-1/3 z-[1] h-[380px] w-[380px] rounded-full border border-white/10"></div>
            <div class="pointer-events-none absolute right-8 top-[38%] z-[1] h-[260px] w-[260px] rounded-full border border-white/5"></div>

            {{-- Card login --}}
            <div class="relative z-10 w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
