<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Vite: Tailwind + JS (requiere npm run dev o npm run build) -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased" style="font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;">
        <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-slate-100">
            @include('layouts.sidebar')

            <div class="flex flex-1 flex-col overflow-hidden">
                @include('layouts.navigation')

                <main class="flex flex-1 flex-col overflow-x-hidden overflow-y-auto bg-[#f4f7f6]">
                    <div class="mx-auto w-full max-w-[1600px] flex-1 px-4 py-6 sm:px-6 sm:py-8 lg:px-8">
                        {{ $slot }}
                    </div>
                    @include('layouts.footer')
                </main>
            </div>

            <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-slate-900/60 backdrop-blur-sm transition-opacity lg:hidden"></div>
        </div>
        @stack('scripts')
    </body>
</html>
