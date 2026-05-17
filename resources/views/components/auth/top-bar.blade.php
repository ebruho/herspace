<header class="mb-7 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a
            href="{{ url('/') }}"
            class="btn btn-circle btn-sm border-0 bg-[#FDFCF9] text-[#3A3532] shadow-md hover:scale-105 hover:shadow-lg"
            aria-label="{{ __('Back to home') }}"
        >
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true">
                <path d="M15 18l-6-6 6-6" />
            </svg>
        </a>
        <span class="font-serif text-xl font-semibold tracking-wide text-[#3A3532]">HerSpace</span>
    </div>
    <button type="button" class="btn btn-circle btn-sm btn-outline border-[rgba(58,155,155,0.35)] text-[#2E7D7D]" title="{{ __('Help') }}" aria-label="{{ __('Help') }}">?</button>
</header>
