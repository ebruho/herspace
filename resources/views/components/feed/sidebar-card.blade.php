@props([
    'title',
    'actionLabel' => null,
    'actionHref' => '#',
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}>
    <div class="mb-4 flex items-center justify-between gap-2">
        <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">{{ $title }}</h2>
        @if ($actionLabel)
            <a href="{{ $actionHref }}" class="text-xs font-semibold uppercase tracking-wide text-[#8b7355] no-underline hover:text-[#5c4033]">
                {{ $actionLabel }}
            </a>
        @endif
    </div>
    {{ $slot }}
</div>
