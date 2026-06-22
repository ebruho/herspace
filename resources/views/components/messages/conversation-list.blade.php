@props([
    'conversations' => [],
])

<aside class="messages-list-panel flex h-full w-full flex-col border-r border-[#ebe4dc] bg-[#fdfcf9] lg:w-[20rem] lg:shrink-0">
    <div class="border-b border-[#ebe4dc] px-5 py-4">
        <h1 class="font-serif text-xl font-semibold text-[#3d2b22]">Messages</h1>
        <label class="relative mt-3 block">
            <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-[#a89888]">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3-3"/></svg>
            </span>
            <input
                type="search"
                placeholder="Search messages"
                class="input input-bordered w-full rounded-full border-[#ebe4dc] bg-[#f5efe8] py-2 pl-10 pr-4 text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
            />
        </label>
    </div>

    <div class="flex-1 space-y-1 overflow-y-auto p-3">
        @foreach ($conversations as $conversation)
            <x-messages.conversation-item :conversation="$conversation" />
        @endforeach
    </div>
</aside>
