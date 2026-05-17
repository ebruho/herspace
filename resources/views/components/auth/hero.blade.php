@props([
    'title',
    'subtitle' => null,
])

<div class="mb-8 rounded-[1.75rem] bg-[#E5E2DC] px-6 py-7 text-center shadow-inner">
    <h1 class="font-serif text-2xl font-bold text-[#3A3532] sm:text-3xl">{{ $title }}</h1>
    @if ($subtitle)
        <p class="mt-1.5 text-sm text-[#6B6560]">{{ $subtitle }}</p>
    @endif
</div>
