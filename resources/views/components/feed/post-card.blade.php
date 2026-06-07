@props([
    'post',
    'authorName',
    'authorAvatar' => null,
    'authorUrl'    => null,
    'authorInitials' => '?',
    'meta',
    'body'      => null,
    'quote'     => null,
    'images'    => null,
    'imageAlt'  => '',
    'showShare' => true,
])

<article
    x-data="postCard({
        postId: {{ $post->id }},
        liked: {{ auth()->user()->likedPosts->contains($post->id) ? 'true' : 'false' }},
        likesCount: {{ $post->likes_count }},
        commentsCount: {{ $post->comments_count }}
    })"
    x-init="$watch('showComments', v => { if (v && !loaded) loadComments() })"
    {{ $attributes->merge(['class' => 'overflow-hidden rounded-2xl border border-[#ebe4dc] bg-white shadow-sm']) }}
>
    {{-- Header --}}
    <div class="p-5">
        <div class="flex items-start gap-3">
            <a href="{{ $authorUrl ?? '#' }}" class="shrink-0">
                @if ($authorAvatar)
                    <img src="{{ $authorAvatar }}" alt="{{ $authorName }}" class="h-11 w-11 rounded-full object-cover"/>
                @else
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-[#e8b4bc] font-serif text-sm font-semibold text-white">
                        {{ $authorInitials }}
                    </div>
                @endif
            </a>

            <div class="min-w-0 flex-1">
                @if ($authorUrl)
                    <a href="{{ $authorUrl }}" class="block font-semibold text-[#3d2b22] no-underline hover:underline">
                        {{ $authorName }}
                    </a>
                @else
                    <p class="font-semibold text-[#3d2b22]">{{ $authorName }}</p>
                @endif
                <p class="text-xs text-[#8b7355]">{{ $meta }}</p>
            </div>

            {{-- Dropdown menu --}}
            <div class="relative" x-data="{ open: false }">
                <button type="button" @click="open = !open"
                    class="rounded-lg p-1 text-[#8b7355] hover:bg-[#f5efe8]">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <circle cx="5" cy="12" r="2"/>
                        <circle cx="12" cy="12" r="2"/>
                        <circle cx="19" cy="12" r="2"/>
                    </svg>
                </button>

                <div x-show="open" x-cloak x-transition @click.outside="open = false"
                    class="absolute right-0 mt-2 w-40 rounded-xl border border-[#ebe4dc] bg-white shadow-lg z-50">

                    @can('update', $post)
                        <a href="{{ route('posts.edit', $post) }}"
                           class="block px-4 py-2 text-sm hover:bg-[#f5efe8]">
                            Edit post
                        </a>
                        <button type="button"
                            @click="open = false; deletePost({{ $post->id }})"
                            class="block w-full px-4 py-2 text-left text-sm text-red-600 hover:bg-[#f5efe8]">
                            Delete post
                        </button>
                    @endcan

                    @cannot('update', $post)
                        <button type="button"
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-[#f5efe8]">
                            Report post
                        </button>
                    @endcannot
                </div>
            </div>
        </div>

        @if ($quote)
            <blockquote class="font-serif mt-4 text-xl leading-snug text-[#3d2b22]">&ldquo;{{ $quote }}&rdquo;</blockquote>
        @endif

        @if ($body)
            <p class="mt-3 text-sm leading-relaxed text-[#5c4a42]">{{ $body }}</p>
        @endif
    </div>

    {{-- Images --}}
    @if ($images && $images->count() === 1)
        <img src="{{ asset('storage/'.$images->first()->image_url) }}"
             alt="{{ $images->first()->caption ?? '' }}"
             class="aspect-[16/10] w-full object-cover" loading="lazy"/>

    @elseif ($images && $images->count() > 1)
        <div class="grid grid-cols-2 gap-0.5">
            @foreach ($images->take(4) as $img)
                <div class="relative {{ $loop->first && $images->count() % 2 !== 0 ? 'col-span-2' : '' }}">
                    <img src="{{ asset('storage/'.$img->image_url) }}"
                         alt="{{ $img->caption ?? '' }}"
                         class="aspect-square w-full object-cover" loading="lazy"/>
                    @if ($loop->iteration === 4 && $images->count() > 4)
                        <div class="absolute inset-0 flex items-center justify-center bg-black/50 text-lg font-bold text-white">
                            +{{ $images->count() - 4 }}
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    {{-- Action bar --}}
    <div class="flex flex-wrap items-center gap-4 border-t border-[#f0ebe4] px-5 py-3 text-sm text-[#6b5b52]">
        <button type="button" @click="toggleLike"
            class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] transition"
            :class="liked ? 'text-[#e8b4bc]' : 'text-[#6b5b52]'">
            <svg class="h-4 w-4" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                 :fill="liked ? 'currentColor' : 'none'">
                <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>
            </svg>
            <span x-text="likesCount"></span>
        </button>

        <button type="button" @click="showComments = !showComments"
            class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] hover:text-[#3d2b22] transition">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/>
            </svg>
            <span x-text="commentsCount"></span>
        </button>

        @if ($showShare)
            <a href="{{ route('posts.show', $post) }}"
               class="inline-flex items-center gap-1.5 rounded-lg px-2 py-1 hover:bg-[#f5efe8] hover:text-[#3d2b22] ml-auto">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8M16 6l-4-4-4 4M12 2v13"/>
                </svg>
                Share
            </a>
        @endif
    </div>

    {{-- Comments section --}}
    <div x-show="showComments" x-cloak class="border-t border-[#f0ebe4] px-5 py-4 space-y-4">

        {{-- Comment list --}}
        <div class="space-y-3">
            <template x-for="c in comments" :key="c.id">
                <div>
                    <div class="flex gap-2 group">
                        {{-- Avatar --}}
                        <div class="h-8 w-8 shrink-0 rounded-full bg-[#e8b4bc] flex items-center justify-center text-xs font-semibold text-white overflow-hidden">
                            <template x-if="c.user.profile_picture">
                                <img :src="c.user.profile_picture" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!c.user.profile_picture">
                                <span x-text="c.user.initials"></span>
                            </template>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1">
                            <div class="rounded-2xl bg-[#f5efe8] px-3 py-2">
                                <p class="text-xs font-semibold text-[#3d2b22]" x-text="c.user.username"></p>
                                <p class="text-sm text-[#5c4a42]" x-text="c.content"></p>
                            </div>
                            <div class="mt-1 flex items-center gap-3 px-1">
                                <span class="text-xs text-[#a89888]" x-text="c.created_at"></span>

                                {{-- Comment like --}}
                                <button @click="toggleCommentLike(c.id)"
                                    class="inline-flex items-center gap-1 text-xs transition"
                                    :class="c.liked ? 'text-[#e8b4bc]' : 'text-[#a89888] hover:text-[#e8b4bc]'">
                                    <svg class="h-3 w-3" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                                         :fill="c.liked ? 'currentColor' : 'none'">
                                        <path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/>
                                    </svg>
                                    <span x-text="c.likes_count || ''"></span>
                                </button>

                                {{-- Reply --}}
                                <button @click="c.showReply = !c.showReply"
                                    class="text-xs text-[#a89888] hover:text-[#6b5b52] transition">
                                    Reply
                                </button>

                                {{-- Delete --}}
                                <button x-show="c.can_delete" @click="deleteComment(c.id)"
                                    class="text-xs text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Replies --}}
                    <template x-if="c.replies && c.replies.length > 0">
                        <div class="ml-10 mt-2 space-y-2">
                            <template x-for="r in c.replies" :key="r.id">
                                <div class="flex gap-2 group">
                                    <div class="h-6 w-6 shrink-0 rounded-full bg-[#e8b4bc] flex items-center justify-center text-xs font-semibold text-white overflow-hidden">
                                        <template x-if="r.user.profile_picture">
                                            <img :src="r.user.profile_picture" class="h-full w-full object-cover">
                                        </template>
                                        <template x-if="!r.user.profile_picture">
                                            <span x-text="r.user.initials"></span>
                                        </template>
                                    </div>
                                    <div class="flex-1">
                                        <div class="rounded-2xl bg-[#f5efe8] px-3 py-2">
                                            <p class="text-xs font-semibold text-[#3d2b22]" x-text="r.user.username"></p>
                                            <p class="text-sm text-[#5c4a42]" x-text="r.content"></p>
                                        </div>
                                        <div class="mt-1 flex items-center gap-3 px-1">
                                            <span class="text-xs text-[#a89888]" x-text="r.created_at"></span>
                                            <button x-show="r.can_delete" @click="deleteComment(r.id)"
                                                class="text-xs text-red-400 hover:text-red-600 opacity-0 group-hover:opacity-100 transition">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>

                    {{-- Reply input --}}
                    <template x-if="c.showReply">
                        <div class="ml-10 mt-2" x-data="{ replyText: '' }">
                            <div class="flex items-center gap-2 rounded-full border border-[#ebe4dc] bg-[#f5efe8] px-4 py-1.5">
                                <input
                                    type="text"
                                    x-model="replyText"
                                    @keydown.enter="submitReply(c.id, replyText); replyText = ''"
                                    placeholder="Write a reply..."
                                    class="flex-1 bg-transparent text-sm text-[#3d2b22] placeholder:text-[#a89888] outline-none"
                                    x-init="$el.focus()"
                                >
                                <button @click="submitReply(c.id, replyText); replyText = ''"
                                    class="text-[#8b7355] hover:text-[#3d2b22]">
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M22 2 11 13M22 2 15 22l-4-9-9-4 20-7z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <p x-show="loaded && comments.length === 0"
               class="text-center text-xs text-[#a89888] py-2">
                No comments yet. Be the first!
            </p>
        </div>

        {{-- New comment --}}
        <div class="flex gap-2 pt-2">
            <div class="h-8 w-8 shrink-0 rounded-full bg-[#e8b4bc] flex items-center justify-center text-xs font-semibold text-white">
                {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
            </div>
            <div class="flex flex-1 items-center gap-2 rounded-full border border-[#ebe4dc] bg-[#f5efe8] px-4 py-1.5">
                <input
                    type="text"
                    x-model="newComment"
                    @keydown.enter.prevent="submitComment()"
                    placeholder="Write a comment..."
                    class="flex-1 bg-transparent text-sm text-[#3d2b22] placeholder:text-[#a89888] outline-none"
                >
                <button
                    type="button"
                    @click.prevent="submitComment()"
                    :disabled="submitting || loadingComments"
                    class="text-[#8b7355] hover:text-[#3d2b22] disabled:opacity-40"
                >
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 2 11 13M22 2 15 22l-4-9-9-4 20-7z"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</article>