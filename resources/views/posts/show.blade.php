<x-layouts.app :title="'Post by '.$post->user->username.' - HerSpace'" max-width="max-w-6xl">
    @php
        $images = $post->images;
        $shareUrl = route('posts.show', $post);
    @endphp

    <div class="space-y-5">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
               class="inline-flex items-center gap-2 text-sm font-medium text-[#8b7355] hover:text-[#3d2b22]">
                <span aria-hidden="true">&larr;</span>
                Back
            </a>

            <div x-data="{ copied: false }" class="flex items-center gap-2">
                <input
                    type="text"
                    readonly
                    value="{{ $shareUrl }}"
                    class="hidden w-72 rounded-full border border-[#ebe4dc] bg-white px-4 py-2 text-sm text-[#6b5b52] shadow-sm sm:block"
                    aria-label="Post link"
                >
                <button
                    type="button"
                    @click="navigator.clipboard?.writeText('{{ $shareUrl }}'); copied = true; setTimeout(() => copied = false, 1800)"
                    class="rounded-full border border-[#ebe4dc] bg-white px-4 py-2 text-sm font-semibold text-[#5c4033] shadow-sm hover:bg-[#f5efe8]"
                >
                    <span x-show="!copied">Copy link</span>
                    <span x-show="copied" x-cloak>Copied</span>
                </button>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[minmax(0,1.15fr)_minmax(24rem,0.85fr)]">
            <section
                x-data="{
                    selected: 0,
                    open: false,
                    images: @js($images->map(fn ($image) => [
                        'src' => asset('storage/'.$image->image_url),
                        'caption' => $image->caption,
                    ])->values()),
                    next() { this.selected = (this.selected + 1) % this.images.length },
                    previous() { this.selected = (this.selected - 1 + this.images.length) % this.images.length },
                }"
                class="space-y-3"
            >
                @if ($images->isNotEmpty())
                    <div class="overflow-hidden rounded-2xl border border-[#ebe4dc] bg-white shadow-sm">
                        <button type="button" @click="open = true" class="block w-full bg-[#f5efe8]">
                            <img
                                :src="images[selected].src"
                                :alt="images[selected].caption || 'Post image'"
                                class="max-h-[70vh] w-full object-contain"
                            >
                        </button>
                        <div class="flex items-center justify-between gap-3 border-t border-[#f0ebe4] px-4 py-3 text-sm text-[#6b5b52]">
                            <p class="min-w-0 truncate" x-text="images[selected].caption || 'Photo from this post'"></p>
                            <p class="shrink-0" x-text="(selected + 1) + ' / ' + images.length"></p>
                        </div>
                    </div>

                    @if ($images->count() > 1)
                        <div class="grid grid-cols-5 gap-2 sm:grid-cols-6">
                            <template x-for="(image, index) in images" :key="image.src">
                                <button
                                    type="button"
                                    @click="selected = index"
                                    class="overflow-hidden rounded-xl border bg-white"
                                    :class="selected === index ? 'border-[#5c4033] ring-2 ring-[#e8b4bc]' : 'border-[#ebe4dc]'"
                                >
                                    <img :src="image.src" :alt="image.caption || 'Post thumbnail'" class="aspect-square w-full object-cover">
                                </button>
                            </template>
                        </div>
                    @endif

                    <div
                        x-show="open"
                        x-cloak
                        x-transition.opacity
                        @keydown.escape.window="open = false"
                        class="fixed inset-0 z-[80] flex items-center justify-center bg-black/85 p-4"
                    >
                        <button type="button" @click="open = false" class="absolute right-5 top-5 rounded-full bg-white/10 px-3 py-2 text-sm font-semibold text-white hover:bg-white/20">
                            Close
                        </button>

                        <button x-show="images.length > 1" type="button" @click="previous" class="absolute left-4 rounded-full bg-white/10 px-4 py-3 text-2xl text-white hover:bg-white/20" aria-label="Previous image">
                            &lsaquo;
                        </button>

                        <img
                            :src="images[selected].src"
                            :alt="images[selected].caption || 'Post image'"
                            class="max-h-[88vh] max-w-full rounded-xl object-contain"
                        >

                        <button x-show="images.length > 1" type="button" @click="next" class="absolute right-4 rounded-full bg-white/10 px-4 py-3 text-2xl text-white hover:bg-white/20" aria-label="Next image">
                            &rsaquo;
                        </button>
                    </div>
                @else
                    <div class="rounded-2xl border border-[#ebe4dc] bg-white p-8 text-center text-[#8b7355] shadow-sm">
                        This post has no photos yet.
                    </div>
                @endif
            </section>

            <section>
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
                    :show-share="false"
                    :show-images="false"
                    :initial-show-comments="true"
                    :all-comments="true"
                />
            </section>
        </div>
    </div>
</x-layouts.app>
