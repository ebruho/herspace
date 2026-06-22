<div {{ $attributes->merge(['class' => 'border-t border-[#ebe4dc] bg-[#fdfcf9] px-4 py-3']) }}>
    <div class="flex items-center gap-2 rounded-full border border-[#ebe4dc] bg-[#f5efe8] px-4 py-2">
        <button type="button" class="btn btn-ghost btn-xs btn-circle text-[#8b7355]" aria-label="Attach file">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21.4 11.6 12.8 20.2a5 5 0 0 1-7.1-7.1l9.8-9.8a3 3 0 0 1 4.2 4.2l-9.8 9.8a1 1 0 0 1-1.4-1.4l9.1-9.1"/></svg>
        </button>
        <button type="button" class="btn btn-ghost btn-xs btn-circle text-[#8b7355]" aria-label="Add image">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
        </button>
        <input
            type="text"
            placeholder="Type a message..."
            class="min-w-0 flex-1 bg-transparent text-sm text-[#3d2b22] placeholder:text-[#a89888] outline-none"
        />
        <button type="button" class="btn btn-ghost btn-xs btn-circle text-[#8b7355]" aria-label="Add emoji">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/></svg>
        </button>
        <button type="button" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#5c4033] text-white hover:bg-[#3d2b22]" aria-label="Send message">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2 11 13M22 2 15 22l-4-9-9-4 20-7z"/></svg>
        </button>
    </div>
</div>
