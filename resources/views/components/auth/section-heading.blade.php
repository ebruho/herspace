@props([
    'step',
    'heading',
    'headingId' => null,
])

<div {{ $attributes->class(['mb-5 flex items-center gap-3']) }}>
    <span
        class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#3A9B9B] text-sm font-semibold text-white"
        aria-hidden="true"
    >{{ $step }}</span>
    <h2 @if ($headingId) id="{{ $headingId }}" @endif class="font-serif text-xl font-semibold text-[#3A3532]">
        {{ $heading }}
    </h2>
</div>
