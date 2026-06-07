@props([
    'title' => 'About',
    'text' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}>
    <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">{{ $title }}</h2>
    <p class="mt-3 text-sm leading-relaxed text-[#6b5b52]">
        {{ $text ?? 'This space is still blooming. A short bio will appear here.' }}
    </p>
</div>

