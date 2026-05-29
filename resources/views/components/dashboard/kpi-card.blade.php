@props([
    'title',
    'value',
    'hint' => null,
    'trend' => null,
    'trendUp' => true,
    'iconBg' => 'bg-blue-500',
    'iconShadow' => 'shadow-blue-500/30',
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-4 rounded-2xl border border-gray-100 bg-white p-5 shadow-[0_1px_3px_rgba(0,0,0,0.06)] transition-shadow hover:shadow-md']) }}>
    <div class="{{ $iconBg }} {{ $iconShadow }} flex h-[52px] w-[52px] shrink-0 items-center justify-center rounded-xl text-white shadow-md">
        {{ $icon }}
    </div>
    <div class="min-w-0 flex-1">
        <p class="text-sm font-medium text-gray-500">{{ $title }}</p>
        <p class="mt-1 text-2xl font-bold tracking-tight text-gray-900">{{ $value }}</p>
        @if($hint || $trend)
            <p class="mt-1.5 flex items-center gap-1 text-xs text-gray-400">
                @if($trend)
                    <span class="{{ $trendUp ? 'text-emerald-600' : 'text-red-600' }} font-semibold">{{ $trend }}</span>
                    @if($trendUp)
                        <svg class="h-3 w-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    @else
                        <svg class="h-3 w-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
                    @endif
                @endif
                @if($hint)
                    <span>{{ $hint }}</span>
                @endif
            </p>
        @endif
    </div>
</div>
