@props([
    'conversation',
])

<button
    type="button"
    {{ $attributes->merge([
        'class' => 'flex w-full items-start gap-3 rounded-2xl border px-4 py-3 text-left transition ' .
            (($conversation['active'] ?? false)
                ? 'border-[#ebe4dc] bg-white shadow-sm'
                : 'border-transparent bg-transparent hover:bg-[#f5efe8]'),
    ]) }}
>
    <div class="relative shrink-0">
        @if ($conversation['avatar'] ?? null)
            <img src="{{ $conversation['avatar'] }}" alt="" class="h-11 w-11 rounded-full object-cover" />
        @else
            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#d4e8e8] text-xs font-semibold text-[#2e7d7d]">
                {{ $conversation['initials'] ?? '?' }}
            </div>
        @endif
        @if ($conversation['online'] ?? false)
            <span class="absolute bottom-0 right-0 h-3 w-3 rounded-full border-2 border-white bg-[#4caf7d]"></span>
        @endif
    </div>

    <div class="min-w-0 flex-1">
        <div class="flex items-center justify-between gap-2">
            <p class="truncate font-semibold text-[#3d2b22]">
                {{ $conversation['name'] }}
                @if ($conversation['verified'] ?? false)
                    <svg class="ml-0.5 inline h-3.5 w-3.5 text-[#5b9bd5]" viewBox="0 0 24 24" fill="currentColor" aria-label="Verified"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                @endif
            </p>
            <span class="shrink-0 text-[0.65rem] text-[#a89888]">{{ $conversation['time'] ?? '' }}</span>
        </div>
        <p class="mt-0.5 truncate text-xs text-[#8b7355]">{{ $conversation['preview'] ?? '' }}</p>
    </div>
</button>
