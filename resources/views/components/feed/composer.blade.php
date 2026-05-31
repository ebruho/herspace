@props(['user' => auth()->user()])

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}>
    <p class="mb-3 font-serif text-lg font-semibold text-[#3d2b22]">How are you feeling today?</p>

    <div class="mb-4 flex flex-wrap gap-2">
        <x-feed.mood-tag label="Happy">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
        </x-feed.mood-tag>
        <x-feed.mood-tag label="Anxious">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M8 15h8M9 9h.01M15 9h.01"/></svg>
        </x-feed.mood-tag>
        <x-feed.mood-tag label="Tired">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 14h3l2 3h8l2-3h3"/><path d="M5 10a7 7 0 0 1 14 0"/></svg>
        </x-feed.mood-tag>
        <x-feed.mood-tag label="Motivated" :active="true">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z"/></svg>
        </x-feed.mood-tag>
    </div>

    <textarea
        rows="3"
        placeholder="Share your thoughts here..."
        class="textarea textarea-bordered mb-4 w-full resize-none rounded-2xl border-[#ebe4dc] bg-[#f5efe8] text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
    ></textarea>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-1 text-[#8b7355]">
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Add image">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            </button>
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Add attachment">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.4 11.6L12.8 20.2a5 5 0 0 1-7.1-7.1l9.8-9.8a3 3 0 0 1 4.2 4.2l-9.8 9.8a1 1 0 0 1-1.4-1.4l9.1-9.1"/></svg>
            </button>
            <button type="button" class="btn btn-ghost btn-sm btn-circle" aria-label="Add location">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s6-5.2 6-10a6 6 0 1 0-12 0c0 4.8 6 10 6 10z"/><circle cx="12" cy="11" r="2"/></svg>
            </button>
        </div>
        <button type="button" class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22]">
            Post
        </button>
    </div>
</div>
