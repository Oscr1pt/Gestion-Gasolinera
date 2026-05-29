@props(['title', 'subtitle' => null])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-gray-100/80 bg-white p-6 shadow-sm shadow-gray-200/50']) }}>
    <div class="mb-5 flex flex-wrap items-start justify-between gap-3">
        <div>
            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
            @if($subtitle)
                <p class="mt-0.5 text-sm text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>
        @isset($actions)
            <div>{{ $actions }}</div>
        @endisset
    </div>
    {{ $slot }}
</div>
