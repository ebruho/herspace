@props([
    'title' => 'HerSpace',
    'maxWidth' => 'max-w-2xl',
])

<x-layout :title="$title" :show-footer="false">
    @include('components.feed.app-skin')

    <div class="app-shell min-h-screen bg-[#f9f7f2]">
        <x-feed.header />

        <x-feed.sidebar-left />
        <x-feed.sidebar-right />

        <main class="app-main-scroll pt-16">
            <div class="mx-auto w-full {{ $maxWidth }} px-4 py-6 pb-16">
                {{ $slot }}
            </div>
        </main>
    </div>
</x-layout>
