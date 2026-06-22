@props([
    'message',
])

@if (($message['type'] ?? '') === 'date')
    <div class="py-2 text-center">
        <span class="text-[0.65rem] font-semibold uppercase tracking-[0.14em] text-[#a89888]">{{ $message['label'] }}</span>
    </div>
@elseif (($message['type'] ?? '') === 'outgoing')
    <div class="flex justify-end">
        <div class="max-w-[75%]">
            <div class="rounded-2xl rounded-br-md bg-[#5c4033] px-4 py-2.5 text-sm leading-relaxed text-white">
                {{ $message['content'] }}
            </div>
            <div class="mt-1 flex items-center justify-end gap-1.5 px-1">
                <span class="text-[0.65rem] text-[#a89888]">{{ $message['time'] ?? '' }}</span>
                @if ($message['read'] ?? false)
                    <svg class="h-3.5 w-3.5 text-[#5b9bd5]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-label="Read"><path d="M20 6 9 17l-5-5"/><path d="M14 6l-7 7"/></svg>
                @endif
            </div>
        </div>
    </div>
@else
    <div class="flex items-end gap-2">
        @if ($message['avatar'] ?? null)
            <img src="{{ $message['avatar'] }}" alt="" class="h-8 w-8 shrink-0 rounded-full object-cover" />
        @else
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#e8b4bc] text-[0.65rem] font-semibold text-white">
                {{ $message['initials'] ?? '?' }}
            </div>
        @endif
        <div class="max-w-[75%]">
            <div class="overflow-hidden rounded-2xl rounded-bl-md bg-[#f3d6d8]/60 px-4 py-2.5 text-sm leading-relaxed text-[#3d2b22]">
                @if ($message['image'] ?? null)
                    <img src="{{ $message['image'] }}" alt="" class="mb-2 max-h-48 w-full rounded-xl object-cover" loading="lazy" />
                @endif
                {{ $message['content'] ?? '' }}
            </div>
            <p class="mt-1 px-1 text-[0.65rem] text-[#a89888]">{{ $message['time'] ?? '' }}</p>
        </div>
    </div>
@endif
