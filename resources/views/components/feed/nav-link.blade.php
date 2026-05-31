@props([
    'href' => '#',
    'active' => false,
    'icon',
])

<a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-medium no-underline transition ' .
            ($active
                ? 'bg-[#f3d6d8] text-[#3d2b22]'
                : 'text-[#6b5b52] hover:bg-[#f5efe8] hover:text-[#3d2b22]'),
    ]) }}
>
    <span class="flex h-5 w-5 shrink-0 items-center justify-center text-current">{!! $icon !!}</span>
    <span>{{ $slot }}</span>
</a>
