@props([
    'contact' => [],
])

<aside class="messages-contact-panel flex h-full w-[18rem] shrink-0 flex-col overflow-y-auto border-l border-[#ebe4dc] bg-[#fdfcf9]">
    <div class="px-6 py-8 text-center">
        <div class="mx-auto mb-4 inline-flex rounded-full p-1 ring-2 ring-[#f3d6d8]">
            @if ($contact['avatar'] ?? null)
                <img src="{{ $contact['avatar'] }}" alt="" class="h-24 w-24 rounded-full object-cover" />
            @else
                <div class="flex h-24 w-24 items-center justify-center rounded-full bg-[#e8b4bc] font-serif text-2xl font-semibold text-white">
                    {{ $contact['initials'] ?? '?' }}
                </div>
            @endif
        </div>
        <h2 class="font-serif text-xl font-semibold text-[#3d2b22]">{{ $contact['name'] ?? 'User' }}</h2>
        @if ($contact['location'] ?? null)
            <p class="mt-1 flex items-center justify-center gap-1 text-sm text-[#8b7355]">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-6-4.5-6-10a6 6 0 1 1 12 0c0 5.5-6 10-6 10z"/><circle cx="12" cy="11" r="2"/></svg>
                {{ $contact['location'] }}
            </p>
        @endif

        <div class="mt-5 flex items-center justify-center gap-4 text-center">
            <div>
                <p class="text-lg font-semibold text-[#3d2b22]">{{ $contact['followers'] ?? '0' }}</p>
                <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#a89888]">Followers</p>
            </div>
            <div class="h-8 w-px bg-[#ebe4dc]"></div>
            <div>
                <p class="text-lg font-semibold text-[#3d2b22]">{{ $contact['joined'] ?? '' }}</p>
                <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#a89888]">Joined</p>
            </div>
        </div>
    </div>

    <div class="border-t border-[#ebe4dc] px-6 py-5">
        <h3 class="text-xs font-semibold uppercase tracking-wide text-[#8b7355]">Shared Interests</h3>
        <div class="mt-3 flex flex-wrap gap-2">
            @foreach ($contact['interests'] ?? [] as $tag)
                <span class="rounded-full bg-[#f5efe8] px-3 py-1 text-xs font-semibold text-[#6b5b52]">{{ $tag }}</span>
            @endforeach
        </div>
    </div>

    <div class="border-t border-[#ebe4dc] px-6 py-5">
        <h3 class="text-xs font-semibold uppercase tracking-wide text-[#8b7355]">Communities in Common</h3>
        <ul class="mt-3 space-y-3">
            @foreach ($contact['communities'] ?? [] as $community)
                <li class="flex items-center gap-3">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl text-xs font-bold {{ $community['color'] ?? 'bg-[#f5efe8] text-[#6b5b52]' }}">
                        {{ strtoupper(substr($community['name'], 0, 1)) }}
                    </span>
                    <div class="min-w-0 text-left">
                        <p class="truncate text-sm font-semibold text-[#3d2b22]">{{ $community['name'] }}</p>
                        <p class="truncate text-xs text-[#a89888]">{{ $community['members'] }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="mt-auto border-t border-[#ebe4dc] px-6 py-5">
        <button type="button" class="inline-flex items-center gap-2 text-sm font-medium text-[#c73e3e] hover:underline">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M4.9 4.9l14.2 14.2"/></svg>
            Block User
        </button>
    </div>
</aside>
