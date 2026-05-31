<aside class="app-sidebar-right fixed bottom-0 right-0 top-16 z-40 hidden w-[19rem] flex-col border-l border-[#ebe4dc] bg-[#fdfcf9] xl:flex">
    <div class="flex h-full flex-col gap-5 overflow-y-auto px-4 py-6">
        <x-feed.sidebar-card title="Trending Topics">
            <ul class="space-y-3">
                @foreach ([['tag' => '#SelfCareSunday', 'count' => '2.4k posts'], ['tag' => '#CareerGrowth', 'count' => '1.8k posts'], ['tag' => '#SafeSpace', 'count' => '956 posts']] as $topic)
                    <li>
                        <a href="#" class="block rounded-xl px-2 py-1 no-underline hover:bg-[#f5efe8]">
                            <p class="text-sm font-semibold text-[#3d2b22]">{{ $topic['tag'] }}</p>
                            <p class="text-xs text-[#8b7355]">{{ $topic['count'] }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-feed.sidebar-card>

        <x-feed.sidebar-card title="Experts" action-label="See All" action-href="#">
            <ul class="space-y-4">
                @foreach ([['name' => 'Dr. Sophia Chen', 'role' => 'Wellness & Health', 'initials' => 'SC'], ['name' => 'Amelia Brooks', 'role' => 'Mindfulness Coach', 'initials' => 'AB']] as $expert)
                    <li class="flex items-center gap-3">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#d4e8e8] text-xs font-semibold text-[#2e7d7d]">
                            {{ $expert['initials'] }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-[#3d2b22]">{{ $expert['name'] }}</p>
                            <p class="truncate text-[0.65rem] font-semibold uppercase tracking-wide text-[#8b7355]">{{ $expert['role'] }}</p>
                        </div>
                        <button type="button" class="btn btn-ghost btn-xs rounded-full text-[#5c4033]" aria-label="Follow {{ $expert['name'] }}">+</button>
                    </li>
                @endforeach
            </ul>
        </x-feed.sidebar-card>

        <div class="rounded-2xl bg-gradient-to-br from-[#f3d6d8] to-[#ebe4dc] p-6 text-center shadow-sm">
            <p class="font-serif text-lg italic leading-relaxed text-[#3d2b22]">&ldquo;Your peace is your greatest wealth.&rdquo;</p>
        </div>

        <x-feed.sidebar-card title="Communities for You">
            <ul class="space-y-3">
                @foreach ([['name' => 'Mindful Leaders', 'color' => 'bg-[#d4e8e8] text-[#2e7d7d]'], ['name' => 'Creative Souls', 'color' => 'bg-[#f3d6d8] text-[#8b5a62]']] as $community)
                    <li>
                        <a href="#" class="flex items-center gap-3 rounded-xl px-2 py-1 no-underline hover:bg-[#f5efe8]">
                            <span class="flex h-9 w-9 items-center justify-center rounded-xl text-xs font-bold {{ $community['color'] }}">
                                {{ strtoupper(substr($community['name'], 0, 1)) }}
                            </span>
                            <span class="text-sm font-medium text-[#3d2b22]">{{ $community['name'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </x-feed.sidebar-card>
    </div>
</aside>
