@props([
    'posts' => 0,
    'followers' => 0,
    'following' => 0,
    'labelPosts' => 'Posts',
])

<div class="rounded-2xl border border-[#ebe4dc] bg-white px-6 py-4 shadow-sm">
    <div class="flex flex-wrap items-center gap-8">
        <div class="flex items-baseline gap-2">
            <span class="text-lg font-semibold text-[#3d2b22]">{{ $posts }}</span>
            <span class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#8b7355]">{{ $labelPosts }}</span>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="text-lg font-semibold text-[#3d2b22]">{{ $followers }}</span>
            <span class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#8b7355]">Followers</span>
        </div>
        <div class="flex items-baseline gap-2">
            <span class="text-lg font-semibold text-[#3d2b22]">{{ $following }}</span>
            <span class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#8b7355]">Following</span>
        </div>
    </div>
</div>

