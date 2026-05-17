@props([
    'title' => 'HerSpace',
    'heroTitle',
    'heroSubtitle' => null,
])

<x-layout :title="$title" :show-footer="false">
    @include('components.auth.auth-skin')

    <div
        class="min-h-screen bg-[#F7F4EF] bg-[radial-gradient(ellipse_50%_40%_at_90%_10%,rgba(232,180,188,0.12),transparent_55%),radial-gradient(ellipse_45%_35%_at_8%_85%,rgba(58,155,155,0.08),transparent_50%)] px-4 py-8 sm:px-6"
    >
        <div class="mx-auto grid max-w-[1120px] items-start gap-10 lg:grid-cols-[minmax(0,1fr)_280px]">
            <div class="mx-auto w-full min-w-0 max-w-[640px]">
                <x-auth.top-bar />
                <x-auth.hero :title="$heroTitle" :subtitle="$heroSubtitle" />
                <x-auth.flash-alerts />

                {{ $slot }}

                @isset($footer)
                    <div class="mt-6 text-center text-sm text-[#6B6560]">
                        {{ $footer }}
                    </div>
                @endisset

                <x-auth.decor-dots class="mt-10" />
            </div>

            <aside class="sticky top-6 hidden flex-col gap-5 lg:flex" aria-label="Inspiration">
                <x-auth.decor-sidebar />
            </aside>
        </div>
    </div>
</x-layout>
