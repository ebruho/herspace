@props([
    'title' => 'Messages — HerSpace',
])

<x-layout :title="$title" :show-footer="false">
    @include('components.messages.messages-skin')

    <div class="messages-shell min-h-screen bg-[#f9f7f2]">
        <x-messages.header />
        <x-feed.sidebar-left />

        <main class="messages-main pt-16">
            {{ $slot }}
        </main>
    </div>
</x-layout>
