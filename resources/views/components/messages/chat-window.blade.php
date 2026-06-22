@props([
    'contactName' => 'Elena Rose',
    'online' => true,
    'messages' => [],
])

<section class="flex min-w-0 flex-1 flex-col bg-[#f9f7f2]">
    {{-- Chat header --}}
    <div class="flex items-center justify-between border-b border-[#ebe4dc] bg-[#fdfcf9] px-5 py-3">
        <div>
            <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">{{ $contactName }}</h2>
            @if ($online)
                <p class="flex items-center gap-1.5 text-xs text-[#4caf7d]">
                    <span class="h-2 w-2 rounded-full bg-[#4caf7d]"></span>
                    Online
                </p>
            @else
                <p class="text-xs text-[#a89888]">Offline</p>
            @endif
        </div>
        <div class="flex items-center gap-1 text-[#6b5b52]">
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Voice call">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
            </button>
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Video call">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M23 7l-7 5 7 5V7z"/><rect x="1" y="5" width="15" height="14" rx="2"/></svg>
            </button>
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Conversation info">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 10v6M12 7h.01"/></svg>
            </button>
        </div>
    </div>

    {{-- Messages (scrollable) --}}
    <div class="flex-1 space-y-4 overflow-y-auto px-5 py-5">
        @foreach ($messages as $message)
            <x-messages.chat-bubble :message="$message" />
        @endforeach
    </div>

    <x-messages.chat-input />
</section>
