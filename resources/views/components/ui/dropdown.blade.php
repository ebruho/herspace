@props([
    'trigger',
])

<div x-data="{ open: false }" class="relative">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-cloak
        x-transition
        @click.outside="open = false"
        class="absolute right-0 mt-2 w-40 rounded-xl border border-[#ebe4dc] bg-white shadow-lg z-50"
    >
        {{ $slot }}
    </div>
</div>