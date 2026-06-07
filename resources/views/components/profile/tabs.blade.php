@props([
    'variant' => 'user', // user|expert|self
    'active' => null,
])

@php
    $tabs = match ($variant) {
        'expert' => [
            'articles' => 'Expert Articles',
            'communities' => 'Communities',
            'about' => 'About',
            'resources' => 'Resources',
        ],
        'self' => [
            'posts' => 'My Posts',
            'communities' => 'Joined Communities',
            'saved' => 'Saved',
            'about' => 'About',
        ],
        default => [
            'posts' => 'Posts',
            'communities' => 'Communities',
            'saved' => 'Saved',
            'about' => 'About',
        ],
    };

    $active = $active ?? array_key_first($tabs);
@endphp

<nav class="rounded-2xl border border-[#ebe4dc] bg-white px-6 pt-3 shadow-sm" aria-label="Profile tabs">
    <ul class="flex gap-8 overflow-x-auto">
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

