@php
    $items = [
        ['label' => 'Home', 'href' => route('home'), 'active' => request()->routeIs('home'), 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M3 10.5L12 3l9 7.5V20a1 1 0 0 1-1 1h-5v-6H9v6H4a1 1 0 0 1-1-1z"/></svg>'],
        ['label' => 'My Profile', 'href' => route('profile'), 'active' => request()->routeIs('profile') && !request()->route('username'), 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"> <circle cx="12" cy="7" r="4"/> <path d="M5.5 21a6.5 6.5 0 0 1 13 0"/> </svg>'],
        ['label' => 'Communities', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><circle cx="9" cy="7" r="3"/><circle cx="17" cy="7" r="3"/><path d="M2 20a7 7 0 0 1 14 0M10 20a7 7 0 0 1 14 0"/></svg>'],
        ['label' => 'Messages', 'href' => route('messages.index'), 'active' => request()->routeIs('messages.*'), 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/></svg>'],
        ['label' => 'Notifications', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.7 21a2 2 0 0 1-3.4 0"/></svg>'],
        ['label' => 'Saved', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"/></svg>'],
        ['label' => 'Mental Health', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M12 21s-7-4.5-7-10a4 4 0 0 1 7-2 4 4 0 0 1 7 2c0 5.5-7 10-7 10z"/></svg>'],
        ['label' => 'Experts', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7L12 17l-6.3 4 2.3-7-6-4.6h7.6z"/></svg>'],
        ['label' => 'Settings', 'href' => '#', 'active' => false, 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="h-5 w-5"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33h.01a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51h.01a1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82v.01a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>'],

        
    ];
@endphp

<aside class="fixed bottom-0 left-0 top-16 z-40 hidden w-[17rem] flex-col border-r border-[#ebe4dc] bg-[#fdfcf9] lg:flex">
    <div class="flex h-full flex-col overflow-y-auto px-4 py-6">
        <div class="mb-6 px-2">
            <p class="font-serif text-lg font-semibold text-[#3d2b22]">Navigation</p>
            <p class="text-xs text-[#8b7355]">Your Sanctuary</p>
        </div>

        <nav class="flex flex-col gap-1">
            @foreach ($items as $item)
                <x-feed.nav-link :href="$item['href']" :active="$item['active']" :icon="$item['icon']">
                    {{ $item['label'] }}
                </x-feed.nav-link>
            @endforeach
        </nav>

        <div class="mt-auto pt-8">
            <button
                id="open-post-modal"
                type="button"
                @disabled(request()->routeIs('posts.edit'))
                class="btn flex w-full items-center justify-center gap-2 rounded-full border-0 bg-[#5c4033] py-3 text-sm font-semibold text-white hover:bg-[#3d2b22]"
            >
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Create New Post
            </button>
        </div>
    </div>
</aside>
