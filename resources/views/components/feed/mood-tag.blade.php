@props([
    'label',
    'active' => false,
])

<button
    type="button"
    {{ $attributes->merge([
        'class' => 'inline-flex items-center gap-1.5 rounded-full border px-3.5 py-1.5 text-xs font-medium transition ' .
            ($active
                ? 'border-[#e8b4bc] bg-[#f3d6d8] text-[#3d2b22]'
                : 'border-[#ebe4dc] bg-white text-[#6b5b52] hover:border-[#e8b4bc]'),
    ]) }}
>
    {{ $slot }}
    {{ $label }}
</button>
