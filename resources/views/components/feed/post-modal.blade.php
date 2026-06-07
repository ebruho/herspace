<div
    id="post-modal"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm"
>
    <div class="relative mx-4 w-full max-w-lg rounded-2xl bg-white shadow-xl">
        {{-- Затвори бутон --}}
        <button
            id="close-post-modal"
            type="button"
            class="absolute right-4 top-4 rounded-lg p-1 text-[#8b7355] hover:bg-[#f5efe8]"
            aria-label="Close"
        >
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M18 6 6 18M6 6l12 12"/>
            </svg>
        </button>

        {{-- Composer вътре --}}
        <x-feed.composer :action="route('posts.store')" class="rounded-2xl border-0 shadow-none" />
    </div>
</div>