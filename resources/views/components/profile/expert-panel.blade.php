@props([
    'user',
])

@php
    $displayName = trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($user->username ?? 'Expert');
@endphp

<div class="overflow-hidden rounded-2xl bg-gradient-to-br from-[#6b4c4a] to-[#3d2b22] p-5 text-white shadow-sm">
    <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wide text-white/85">
        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l2.4 7.4H22l-6 4.6 2.3 7L12 17l-6.3 4 2.3-7-6-4.6h7.6z"/></svg>
        Verified Expert
    </div>

    <div class="mt-4">
        <p class="text-xl font-serif font-semibold">{{ $displayName }}</p>
        <p class="text-sm text-white/80">Psychologist</p>
        <p class="mt-1 text-xs text-white/70">Master in Clinical Psychology</p>
    </div>

    <div class="mt-4 space-y-3 text-sm">
        <div class="flex items-center gap-2 text-white/85">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 7h-9M20 11h-9M20 15h-9M6 7h.01M6 11h.01M6 15h.01"/></svg>
            <div>
                <div class="text-[0.65rem] uppercase tracking-wide text-white/65">Experience</div>
                <div class="font-medium">5 years in trauma therapy</div>
            </div>
        </div>

        <div class="flex items-center gap-2 text-white/85">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M12 4h9"/><path d="M3 10h18"/><path d="M4 6h2"/><path d="M4 14h2"/></svg>
            <div>
                <div class="text-[0.65rem] uppercase tracking-wide text-white/65">Website</div>
                <div class="font-medium">sofia-chen.example</div>
            </div>
        </div>
    </div>
</div>

