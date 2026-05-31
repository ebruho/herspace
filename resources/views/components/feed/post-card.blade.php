@props([
    'authorName',
    'authorAvatar' => null,
    'authorInitials' => '?',
    'meta',
    'body' => null,
    'quote' => null,
    'image' => null,
    'imageAlt' => '',
    'likes' => null,
    'comments' => null,
    'showShare' => true,
])

<article {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-[#ebe4dc] bg-white shadow-sm']) }}>
    <div class="p-5">
        <div class="flex items-start gap-3">
            @if ($authorAvatar)
                <img src="{{ $authorAvatar }}" alt="" class="h-11 w-11 shrink-0 rounded-full object-cover" />
            @else
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e8b4bc] font-serif text-sm font-semibold text-white">
                    {{ $authorInitials }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <p class="font-semibold text-[#3d2b22]">{{ $authorName }}</p>
                <p class="text-xs text-[#8b7355]">{{ $meta }}</p>
            </div>
            <button type="button" class="rounded-lg p-1 text-[#8b7355] hover:bg-[#f5efe8]" aria-label="More options">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="2"/><circle cx="12" cy="12" r="2"/><circle cx="19" cy="12" r="2"/></svg>
            </button>
        </div>

        @if ($quote)
            <blockquote class="font-serif mt-4 text-xl leading-snug text-[#3d2b22]">&ldquo;{{ $quote }}&rdquo;</blockquote>
        @endif

        @if ($body)
            <p class="mt-3 text-sm leading-relaxed text-[#5c4a42]">{{ $body }}</p>
        @endif
    </div>

    @if ($image)
        <img src="{{ $image }}" alt="{{ $imageAlt }}" class="aspect-[16/10] w-full object-cover" loading="lazy" />
    @endif

    <div class="flex flex-wrap items-center gap-4 border-t border-[#f0ebe4] px-5 py-3 text-sm text-[#6b5b52]">
        <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] hover:text-[#3d2b22]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>
            @if ($likes)<span>{{ $likes }}</span>@else<span>Like</span>@endif
        </button>
        <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] hover:text-[#3d2b22]">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/></svg>
            @if ($comments)<span>{{ $comments }}</span>@else<span>Comment</span>@endif
        </button>
        @if ($showShare)
            <button type="button" class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] hover:text-[#3d2b22]">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M16 6l-4-4-4 4M12 2v13"/></svg>
                Share
            </button>
        @endif
    </div>
</article>
