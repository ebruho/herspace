@props([
    'user' => auth()->user(),
    'post' => null,
    'action',
    'method' => 'POST',
    'submitLabel' => 'Post',
])

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="fixed bottom-6 right-6 z-50 rounded-2xl border border-green-200 bg-white px-5 py-4 shadow-lg text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

<form
    action="{{ $action }}"
    method="{{ $method }}"
    enctype="multipart/form-data"
    {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}
>
    @csrf
    @if($method !== 'POST')
        @method($method)
    @endif

    
    <p class="mb-3 font-serif text-lg font-semibold text-[#3d2b22]">How are you feeling today?</p>

    {{-- Mood избор --}}
    <div class="mb-4 flex flex-wrap gap-2" id="mood-tags">
        @foreach ([
            'happy'     => ['label' => 'Happy',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>'],
            'anxious'   => ['label' => 'Anxious',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 15h8M9 9h.01M15 9h.01"/>'],
            'tired'     => ['label' => 'Tired',     'icon' => '<path d="M3 14h3l2 3h8l2-3h3"/><path d="M5 10a7 7 0 0 1 14 0"/>'],
            'motivated' => ['label' => 'Motivated', 'icon' => '<path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z"/>'],
            'calm'      => ['label' => 'Calm',      'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1 1 2.5 1.5 4 1.5s3-.5 4-1.5"/>'],
            'sad'       => ['label' => 'Sad',       'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 15c1-1 2.5-1.5 4-1.5s3 .5 4 1.5"/><path d="M9 9h.01M15 9h.01"/>'],
            'angry'     => ['label' => 'Angry',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14h8"/><path d="M9 9l-1 1M15 9l1 1"/>'],
            'overwhelmed' => ['label' => 'Overwhelmed',    'icon' => '<circle cx="12" cy="12" r="9"/><path d="M7 14h10"/><path d="M9 9l-1 1M15 9l1 1"/><path d="M12 9h.01"/>'],
            'excited'   => ['label' => 'Excited',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><path d="M9 9l1 1M15 9l-1 1"/>'],
            'relieved'  => ['label' => 'Relieved',  'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1.5 1 3 1 4 1s2.5 0 4-1"/><path d="M9 9h.01M15 9h.01"/>'],
            'neutral'   => ['label' => 'Neutral',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14h8"/><path d="M9 9h.01M15 9h.01"/>'],
            'aware'     => ['label' => 'Aware',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1.2-.8 2.5-1.2 4-1.2s2.8.4 4 1.2"/><path d="M9 9c.5-.5 1.2-.5 1.7 0M15 9c-.5-.5-1.2-.5-1.7 0"/>'],
            'loved'     => ['label' => 'Loved',     'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M12 17s-4-2.5-4-5.5c0-1.5 1.2-2.5 2.5-2.5 1 0 1.8.6 2.5 1.4.7-.8 1.5-1.4 2.5-1.4C16.8 9 18 10 18 11.5c0 3-4 5.5-6 5.5z"/>',],
            // 'relatable' => ['label' => 'Relatable', 'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1 .6 2.2 1 4 1s3-.4 4-1"/><path d="M9 9c.4-.3 1-.3 1.4 0M15 9c-.4-.3-1-.3-1.4 0"/><path d="M10.2 12c.3.2.8.3 1.3.3s1-.1 1.3-.3"/>'],

        ] as $value => $mood)
            <label class="mood-tag cursor-pointer">
                <input type="radio" name="mood" value="{{ $value }}" class="sr-only" @checked(old('mood', $post?->mood) === $value)>
                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#ebe4dc] bg-[#f5efe8] px-3 py-1.5 text-xs font-medium text-[#6b5b52] transition hover:border-[#e8b4bc] hover:bg-[#fdf0f2]">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $mood['icon'] !!}</svg>
                    {{ $mood['label'] }}
                </span>
            </label>
        @endforeach
    </div>

    <select name="visibility" class="select select-sm rounded-full border-[#ebe4dc] bg-[#f5efe8] text-xs text-[#6b5b52] my-3">
        <option value="public"  @selected(old('visibility', $post?->visibility) === 'public')>🌍 Public</option>
        <option value="followers" @selected(old('visibility', $post?->visibility) === 'followers')>👥 Followers</option>
        <option value="private" @selected(old('visibility', $post?->visibility) === 'private')>🔒 Only me</option>
    </select>

    {{-- Textarea --}}
    <textarea
        name="content"
        rows="3"
        placeholder="Share your thoughts here... use #hashtags"
        class="textarea textarea-bordered mb-2 w-full resize-none rounded-2xl border-[#ebe4dc] bg-[#f5efe8] text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
    >{{ old('content', $post?->content) }}</textarea>

    @error('content')
        <p class="mb-3 text-xs text-error">{{ $message }}</p>
    @enderror

    @if($post && $post->images->count())
        <div class="grid grid-cols-3 gap-2 mb-4">
            @foreach($post->images as $image)
                <div>
                    <img
                        src="{{ asset('storage/'.$image->image_url) }}"
                        class="rounded-xl"
                    >

                    <label>
                        <input
                            type="checkbox"
                            name="delete_images[]"
                            value="{{ $image->id }}"
                        >
                        Remove
                    </label>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Снимка preview --}}
    <div id="image-preview" class="mb-3 hidden grid grid-cols-2 gap-2 sm:grid-cols-3">
        {{-- <img id="preview-img" src="" alt="" class="max-h-48 w-full rounded-xl object-cover"> --}}
    </div>


    <input type="file" name="images[]" id="post-image" accept="image/*" multiple class="hidden">

    

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-1 text-[#8b7355]">
            <button type="button" id="image-btn" class="btn btn-ghost btn-sm btn-circle" aria-label="Add image">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            </button>
        </div>
        <button type="submit" class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22] mt-2">
            {{ $submitLabel }}
        </button>
    </div>
</form>

<style>
    .mood-tag input:checked + span {
        background: #f9dce2;
        border-color: #d99aa6;
        color: #5c4033;
        font-weight: 600;
    }
</style>

{{-- 
@props(['user' => auth()->user()])

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
         class="fixed bottom-6 right-6 z-50 rounded-2xl border border-green-200 bg-white px-5 py-4 shadow-lg text-sm text-green-700">
        {{ session('success') }}
    </div>
@endif

<form
    action="{{ route('posts.store') }}"
    method="POST"
    enctype="multipart/form-data"
    {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}
>
    @csrf

    <p class="mb-3 font-serif text-lg font-semibold text-[#3d2b22]">How are you feeling today?</p>

    <div class="mb-4 flex flex-wrap gap-2" id="mood-tags">
        @foreach ([
            'happy'     => ['label' => 'Happy',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2M9 9h.01M15 9h.01"/>'],
            'anxious'   => ['label' => 'Anxious',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 15h8M9 9h.01M15 9h.01"/>'],
            'tired'     => ['label' => 'Tired',     'icon' => '<path d="M3 14h3l2 3h8l2-3h3"/><path d="M5 10a7 7 0 0 1 14 0"/>'],
            'motivated' => ['label' => 'Motivated', 'icon' => '<path d="M12 2l2 7h7l-5.5 4 2 7L12 16l-5.5 4 2-7L3 9h7z"/>'],
            'calm'      => ['label' => 'Calm',      'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1 1 2.5 1.5 4 1.5s3-.5 4-1.5"/>'],
            'sad'       => ['label' => 'Sad',       'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 15c1-1 2.5-1.5 4-1.5s3 .5 4 1.5"/><path d="M9 9h.01M15 9h.01"/>'],
            'angry'     => ['label' => 'Angry',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14h8"/><path d="M9 9l-1 1M15 9l1 1"/>'],
            'overwhelmed' => ['label' => 'Overwhelmed',    'icon' => '<circle cx="12" cy="12" r="9"/><path d="M7 14h10"/><path d="M9 9l-1 1M15 9l1 1"/><path d="M12 9h.01"/>'],
            'excited'   => ['label' => 'Excited',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14s1.5 2 4 2 4-2 4-2"/><path d="M9 9l1 1M15 9l-1 1"/>'],
            'relieved'  => ['label' => 'Relieved',  'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1.5 1 3 1 4 1s2.5 0 4-1"/><path d="M9 9h.01M15 9h.01"/>'],
            'neutral'   => ['label' => 'Neutral',   'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14h8"/><path d="M9 9h.01M15 9h.01"/>'],
            'aware'     => ['label' => 'Aware',     'icon' => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1.2-.8 2.5-1.2 4-1.2s2.8.4 4 1.2"/><path d="M9 9c.5-.5 1.2-.5 1.7 0M15 9c-.5-.5-1.2-.5-1.7 0"/>'],
            'loved'     => ['label' => 'Loved',     'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M12 17s-4-2.5-4-5.5c0-1.5 1.2-2.5 2.5-2.5 1 0 1.8.6 2.5 1.4.7-.8 1.5-1.4 2.5-1.4C16.8 9 18 10 18 11.5c0 3-4 5.5-6 5.5z"/>',],
            // 'relatable' => ['label' => 'Relatable', 'icon'  => '<circle cx="12" cy="12" r="9"/><path d="M8 14c1 .6 2.2 1 4 1s3-.4 4-1"/><path d="M9 9c.4-.3 1-.3 1.4 0M15 9c-.4-.3-1-.3-1.4 0"/><path d="M10.2 12c.3.2.8.3 1.3.3s1-.1 1.3-.3"/>'],

        ] as $value => $mood)
            <label class="mood-tag cursor-pointer">
                <input type="radio" name="mood" value="{{ $value }}" class="sr-only">
                <span class="inline-flex items-center gap-1.5 rounded-full border border-[#ebe4dc] bg-[#f5efe8] px-3 py-1.5 text-xs font-medium text-[#6b5b52] transition hover:border-[#e8b4bc] hover:bg-[#fdf0f2]">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">{!! $mood['icon'] !!}</svg>
                    {{ $mood['label'] }}
                </span>
            </label>
        @endforeach
    </div>

    <select name="visibility" class="select select-sm rounded-full border-[#ebe4dc] bg-[#f5efe8] text-xs text-[#6b5b52] my-3">
        <option value="public">🌍 Public</option>
        <option value="followers">👥 Followers</option>
        <option value="private">🔒 Only me</option>
    </select>

    <textarea
        name="content"
        rows="3"
        placeholder="Share your thoughts here... use #hashtags"
        class="textarea textarea-bordered mb-2 w-full resize-none rounded-2xl border-[#ebe4dc] bg-[#f5efe8] text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
    >{{ old('content') }}</textarea>

    @error('content')
        <p class="mb-3 text-xs text-error">{{ $message }}</p>
    @enderror

    <div id="image-preview" class="mb-3 hidden grid grid-cols-2 gap-2 sm:grid-cols-3">
    </div>

    <input type="file" name="images[]" id="post-image" accept="image/*" multiple class="hidden">

    

    <div class="flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-1 text-[#8b7355]">
            <button type="button" id="image-btn" class="btn btn-ghost btn-sm btn-circle" aria-label="Add image">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><circle cx="8.5" cy="10.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
            </button>
        </div>
        <button type="submit" class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22] mt-2">
            Post
        </button>
    </div>
</form>

<style>
    .mood-tag input:checked + span {
        background: #f9dce2;
        border-color: #d99aa6;
        color: #5c4033;
        font-weight: 600;
    }
</style>
--}}