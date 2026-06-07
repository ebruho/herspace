<x-layouts.app title="Edit Post - HerSpace">

    <div class="space-y-6">

  <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('home') }}"
   class="inline-flex items-center gap-2 px-2 py-1 text-sm text-[#6b5b52] hover:bg-[#f5efe8] hover:text-[#3d2b22] rounded-md transition">
    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path d="M15 18l-6-6 6-6"/>
    </svg>
    Back
</a>


        <x-feed.composer
            :post="$post"
            :action="route('posts.update', $post)"
            method="PUT"
            submitLabel="Update Post"
        />
    </div>
</x-layouts.app>