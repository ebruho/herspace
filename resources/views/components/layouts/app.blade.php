@props([
    'title' => 'HerSpace',
])

<x-layout :title="$title" :show-footer="false">
    @include('components.feed.app-skin')

    <div class="app-shell min-h-screen bg-[#f9f7f2]">
        <x-feed.header />

        <x-feed.sidebar-left />
        <x-feed.sidebar-right />

        <main class="app-main-scroll pt-16">
            <div class="mx-auto w-full max-w-2xl px-4 py-6 pb-16">
                {{ $slot }}
            </div>
        </main>
    </div>
</x-layout>
