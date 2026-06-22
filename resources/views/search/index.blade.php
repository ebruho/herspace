<x-layouts.app :title="$query ? 'Search: '.$query.' - HerSpace' : 'Search - HerSpace'" max-width="max-w-5xl">
    @php
        $hasQuery = trim($query) !== '';
        $hasResults = $posts->isNotEmpty() || $users->isNotEmpty() || $hashtags->isNotEmpty();
    @endphp

    <div class="space-y-6">
        <section class="rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm">
            <form action="{{ route('search') }}" method="GET" class="flex flex-col gap-3 sm:flex-row">
                <label class="relative flex-1">
                    <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#8b7355]">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3-3"/></svg>
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $query }}"
                        placeholder="Search posts, #hashtags, users..."
                        class="input input-bordered w-full rounded-full border-[#ebe4dc] bg-[#f5efe8] py-3 pl-11 pr-4 text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
                        autofocus
                    >
                </label>
                <button class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22]">
                    Search
                </button>
            </form>

            <div class="mt-4">
                @if ($hasQuery)
                    <h1 class="font-serif text-2xl font-semibold text-[#3d2b22]">Results for "{{ $query }}"</h1>
                    <p class="mt-1 text-sm text-[#8b7355]">Searching visible posts, hashtags, and people.</p>
                @else
                    <h1 class="font-serif text-2xl font-semibold text-[#3d2b22]">Search HerSpace</h1>
                    <p class="mt-1 text-sm text-[#8b7355]">Try a username, a word from a post, or a hashtag like #calm.</p>
                @endif
            </div>
        </section>

        @if ($hasQuery && !$hasResults)
            <div class="rounded-2xl border border-[#ebe4dc] bg-white p-8 text-center text-[#8b7355] shadow-sm">
                <p class="font-serif text-lg text-[#3d2b22]">No results yet.</p>
                <p class="mt-1 text-sm">Try a shorter phrase, a username, or a hashtag.</p>
            </div>
        @endif

        @if ($hashtags->isNotEmpty())
            <section class="rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">Hashtags</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($hashtags as $hashtag)
                        <a href="{{ route('search', ['q' => '#'.$hashtag->name]) }}"
                           class="rounded-full bg-[#f5efe8] px-3 py-1.5 text-sm font-semibold text-[#6b5b52] hover:bg-[#f3d6d8] hover:text-[#3d2b22]">
                            #{{ $hashtag->name }}
                            <span class="ml-1 text-xs font-medium text-[#8b7355]">{{ $hashtag->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($users->isNotEmpty())
            <section class="rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm">
                <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">People</h2>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    @foreach ($users as $user)
                        @php
                            $displayName = trim(($user->first_name ?? '').' '.($user->last_name ?? '')) ?: $user->username;
                            $location = collect([$user->city?->name, $user->city?->country?->name])->filter()->implode(', ');
                        @endphp
                        <a href="{{ route('profile', $user->username) }}"
                           class="flex items-center gap-3 rounded-2xl border border-[#f0ebe4] p-3 no-underline hover:bg-[#f5efe8]">
                            @if ($user->profile_picture)
                                <img src="{{ asset('storage/'.$user->profile_picture) }}" alt="" class="h-11 w-11 rounded-full object-cover">
                            @else
                                <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#e8b4bc] text-xs font-semibold text-white">
                                    {{ strtoupper(substr($user->username, 0, 2)) }}
                                </span>
                            @endif
                            <span class="min-w-0">
                                <span class="block truncate font-semibold text-[#3d2b22]">{{ $displayName }}</span>
                                <span class="block truncate text-xs text-[#8b7355]">
                                    {{ '@'.$user->username }}@if ($location) · {{ $location }} @endif
                                </span>
                            </span>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        @if ($posts->isNotEmpty())
            <section class="space-y-4">
                <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">Posts</h2>
                @foreach ($posts as $post)
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
                @endforeach
            </section>
        @endif
    </div>
</x-layouts.app>
