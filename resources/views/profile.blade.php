<x-layouts.app :title="($profileUser->username ?? 'Profile').' — HerSpace'" max-width="max-w-5xl">
    @include('components.profile.profile-skin')

    @php
        $variant = $isExpert ? 'expert' : ($isOwner ? 'self' : 'user');
    @endphp

    <div class="space-y-6">
        <x-profile.header
            :user="$profileUser"
            :is-owner="$isOwner"
            :is-expert="$isExpert"
            :is-following="$isFollowing"
        />

        <x-profile.stats
            :posts="$stats['posts']"
            :followers="$stats['followers']"
            :following="$stats['following']"
            :label-posts="$isExpert ? 'Articles' : 'Posts'"
        />

        <x-profile.tabs :variant="$variant" />

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_20rem]">
            <section class="space-y-6">
                {{-- @if ($variant === 'self')
                    <x-feed.composer />
                @endif --}}

                @if ($variant === 'expert')
                    <div class="grid gap-5 sm:grid-cols-2">
                        <x-feed.post-card
                            author-name="Navigating Burnout in a Hyper-Connected World"
                            author-initials="HS"
                            meta="Mental Health · 5 min read"
                            body="Exploring the psychological impact of digital fatigue — and practical ways to recover your focus."
                            image="https://images.unsplash.com/photo-1496307653780-42ee777d4833?auto=format&w=900&q=80"
                            image-alt="Coffee on desk"
                            likes="1.2k"
                            comments="64"
                            :show-share="false"
                        />
                        <x-feed.post-card
                            author-name="The Art of Setting Gentle Boundaries"
                            author-initials="HS"
                            meta="Self-care · 8 min read"
                            body="How to protect your energy without losing your softness. A guide for everyday conversations."
                            image="https://images.unsplash.com/photo-1471193945509-9ad0617afabf?auto=format&w=900&q=80"
                            image-alt="Seedling in hands"
                            likes="856"
                            comments="31"
                            :show-share="false"
                        />
                    </div>
                @else
                    <div class="space-y-6">
                        @forelse ($posts as $post)
                            <x-feed.post-card
                                :post="$post"
                                :author-name="$post->user->username"
                                :author-initials="strtoupper(substr($post->user->username, 0, 2))"
                                :author-avatar="$post->user->profile_picture ? asset('storage/'.$post->user->profile_picture) : null"
                                :author-url="route('profile', $post->user->username)"
                                :meta="$post->created_at->diffForHumans()"
                                :body="$post->content"
                                :images="$post->images"   
                                :likes="$post->likes_count"
                                :comments="$post->comments_count"
                            />
                        @empty
                            <div class="rounded-2xl border border-[#ebe4dc] bg-white p-8 text-center text-sm text-[#8b7355] shadow-sm">
                                No posts yet.
                            </div>
                        @endforelse
                    </div>
                @endif
            </section>

            <aside class="space-y-6">
                @if ($variant === 'expert')
                    <x-profile.expert-panel :user="$profileUser" />

                    <x-feed.sidebar-card title="Mood Reflection">
                        <p class="text-xs font-semibold uppercase tracking-wide text-[#8b7355]">Weekly Serenity</p>
                        <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-[#f5efe8]">
                            <div class="h-full w-[82%] rounded-full bg-[#5c4033]"></div>
                        </div>
                        <p class="mt-3 text-xs text-[#6b5b52] italic">“Practicing what I teach. This week has been focused on balance and restorative rest.”</p>
                    </x-feed.sidebar-card>

                    <x-feed.sidebar-card title="Similar Experts">
                        <ul class="space-y-4">
                            @foreach ([['name' => 'Dr. Elena Rossi', 'role' => 'Cognitive Specialist', 'initials' => 'ER'], ['name' => 'Marcus Thorne', 'role' => 'Mindfulness Coach', 'initials' => 'MT']] as $expert)
                                <li class="flex items-center gap-3">
                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#f3d6d8] text-xs font-semibold text-[#8b5a62]">{{ $expert['initials'] }}</div>
                                    <div class="min-w-0 flex-1">
                                        <p class="truncate text-sm font-semibold text-[#3d2b22]">{{ $expert['name'] }}</p>
                                        <p class="truncate text-xs text-[#8b7355]">{{ $expert['role'] }}</p>
                                    </div>
                                    <button type="button" class="btn btn-ghost btn-xs rounded-full text-[#5c4033]" aria-label="Follow {{ $expert['name'] }}">+</button>
                                </li>
                            @endforeach
                        </ul>
                    </x-feed.sidebar-card>
                @else
                    <x-profile.about-card
                        title="Profile details"
                        :user="$profileUser"
                        :is-owner="$isOwner"
                    />

                    <x-feed.sidebar-card title="Recent moods">
                        @foreach ([['label' => 'Happy', 'pct' => 34], ['label' => 'Motivated', 'pct' => 29], ['label' => 'Calm', 'pct' => 22], ['label' => 'Reflective', 'pct' => 15]] as $m)
                            <div class="mb-3">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-medium text-[#3d2b22]">{{ $m['label'] }}</span>
                                    <span class="text-[#8b7355]">{{ $m['pct'] }}%</span>
                                </div>
                                <div class="mt-1 h-2 w-full overflow-hidden rounded-full bg-[#f5efe8]">
                                    <div class="h-full rounded-full bg-[#5c4033]" style="width: {{ $m['pct'] }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </x-feed.sidebar-card>

                    <x-feed.sidebar-card title="Interests">
                        <div class="flex flex-wrap gap-2">
                            @foreach (['#SelfCare', '#Mindfulness', '#MentalHealth', '#Psychology', '#Growth', '#SoftLife'] as $tag)
                                <span class="rounded-full bg-[#f5efe8] px-3 py-1 text-xs font-semibold text-[#6b5b52]">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </x-feed.sidebar-card>

                    <x-feed.sidebar-card title="Thought of the day">
                        <p class="text-sm font-semibold text-[#3d2b22]">“Your worth is not measured by your productivity.”</p>
                        <p class="mt-2 text-xs text-[#8b7355]">A gentle reminder for a calmer week.</p>
                    </x-feed.sidebar-card>
                @endif
            </aside>
        </div>
    </div>
</x-layouts.app>
