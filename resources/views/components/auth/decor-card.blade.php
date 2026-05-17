@props(['caption', 'imageUrl', 'alt' => ''])

<figure class="overflow-hidden rounded-2xl border border-base-200/80 bg-base-100 shadow-md">
    <img src="{{ $imageUrl }}" alt="{{ $alt }}" width="640" height="400" loading="lazy" class="h-40 w-full object-cover" />
    <figcaption class="px-4 py-3 text-center font-serif text-base italic text-base-content/70">
        {{ $caption }}
    </figcaption>
</figure>
