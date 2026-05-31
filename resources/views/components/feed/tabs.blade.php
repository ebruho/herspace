@props(['active' => 'for-you'])

@php
    $tabs = [
        'for-you' => 'For You',
        'following' => 'Following',
        'communities' => 'Communities',
        'trending' => 'Trending',
    ];
@endphp

<nav {{ $attributes->merge(['class' => 'border-b border-[#ebe4dc]']) }} aria-label="Feed tabs">
    <ul class="flex gap-6 overflow-x-auto">
        @foreach ($tabs as $key => $label)
            <li>
                <button
                    type="button"
                    @class([
                        'whitespace-nowrap border-b-2 pb-3 text-sm font-semibold transition',
                        'border-[#5c4033] text-[#3d2b22]' => $active === $key,
                        'border-transparent text-[#8b7355] hover:text-[#3d2b22]' => $active !== $key,
                    ])
                >
                    {{ $label }}
                </button>
            </li>
        @endforeach
    </ul>
</nav>
