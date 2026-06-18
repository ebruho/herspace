@props([
    'title' => 'About',
    'text' => null,
    'user' => null,
    'isOwner' => false,
])

@php
    $locationParts = [];
    if ($user?->city?->name) $locationParts[] = $user->city->name;
    if ($user?->city?->country?->name) $locationParts[] = $user->city->country->name;
    $location = implode(', ', $locationParts);

    $details = [];
    if ($user?->username) $details['Username'] = '@'.$user->username;
    if ($user?->first_name || $user?->last_name) $details['Name'] = trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
    if ($location) $details['Location'] = $location;
    if ($user?->date_of_birth) $details['Birthday'] = $user->date_of_birth instanceof \Carbon\Carbon
        ? $user->date_of_birth->format('M j, Y')
        : \Carbon\Carbon::parse($user->date_of_birth)->format('M j, Y');
    if ($isOwner && $user?->email) $details['Email'] = $user->email;
    if ($isOwner && $user?->phone) $details['Phone'] = $user->phone;
@endphp

<div {{ $attributes->merge(['class' => 'rounded-2xl border border-[#ebe4dc] bg-white p-5 shadow-sm']) }}>
    <div class="flex items-center justify-between gap-3">
        <h2 class="font-serif text-lg font-semibold text-[#3d2b22]">{{ $title }}</h2>
        @if ($isOwner)
            <a href="{{ route('profile.edit') }}" class="text-xs font-semibold uppercase tracking-wide text-[#8b7355] hover:text-[#5c4033]">
                Edit
            </a>
        @endif
    </div>

    <p class="mt-3 text-sm leading-relaxed text-[#6b5b52]">
        {{ $user?->bio ?: ($text ?? 'This space is still blooming. A short bio will appear here.') }}
    </p>

    @if (!empty($details))
        <dl class="mt-5 space-y-3 text-sm">
            @foreach ($details as $label => $value)
                <div>
                    <dt class="text-[0.65rem] font-semibold uppercase tracking-wide text-[#8b7355]">{{ $label }}</dt>
                    <dd class="mt-0.5 break-words font-medium text-[#3d2b22]">{{ $value }}</dd>
                </div>
            @endforeach
        </dl>
    @endif
</div>
