@props([
    'user',
    'isOwner' => false,
    'isExpert' => false,
    'isFollowing' => false,
])

@php
    $displayName = trim(($user->first_name ?? '').' '.($user->last_name ?? ''));
    $displayName = $displayName !== '' ? $displayName : ($user->username ?? 'User');

    $locationParts = [];
    if (($user->city?->name ?? null)) $locationParts[] = $user->city->name;
    if (($user->city?->country?->name ?? null)) $locationParts[] = $user->city->country->name;
    $location = implode(', ', $locationParts);

    $avatarUrl = $user->profile_picture ? asset('storage/'.$user->profile_picture) : null;
    $coverUrl = $user->cover_photo ? asset('storage/'.$user->cover_photo) : null;

    $initials = strtoupper(substr($user->username ?? $displayName, 0, 2));
@endphp

<section class="overflow-hidden rounded-2xl border border-[#ebe4dc] bg-white shadow-sm">
    <div class="relative">
        <div class="h-40 w-full {{ $coverUrl ? '' : 'profile-cover' }}" @if($coverUrl) style="background-image:url('{{ $coverUrl }}'); background-size:cover; background-position:center;" @endif></div>

        <div class="absolute -bottom-10 left-6 flex items-end gap-4">
            @if ($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="" class="h-24 w-24 rounded-full border-4 border-white object-cover shadow-sm" />
            @else
                <div class="flex h-24 w-24 items-center justify-center rounded-full border-4 border-white bg-[#e8b4bc] font-serif text-lg font-semibold text-white shadow-sm">
                    {{ $initials }}
                </div>
            @endif

            <div class="pb-2">
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="font-serif text-2xl font-semibold text-[#3d2b22]">{{ $displayName }}</h1>
                    @if ($isExpert)
                        <span class="rounded-full bg-[#d4e8e8] px-2.5 py-1 text-[0.65rem] font-semibold uppercase tracking-wide text-[#2e7d7d]">
                            Verified Expert
                        </span>
                    @endif
                </div>
                <p class="text-sm text-[#8b7355]">
                    @if ($isExpert)
                        Clinical Psychologist · 5+ years experience
                    @else
                        @if ($user->username) <span class="font-medium text-[#6b5b52]">{{ '@'.$user->username }}</span> @endif
                        @if ($location) · {{ $location }} @endif
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="px-6 pb-5 pt-14">
        <div class="flex flex-wrap items-center justify-end gap-2">
            @if ($isOwner)
                <a href="{{ route('profile.edit') }}" class="btn rounded-full border-[#ebe4dc] bg-white px-5 text-sm font-semibold text-[#3d2b22] hover:bg-[#f5efe8]">
                    Edit Profile
                </a>
            @else
                <a href="#" class="btn rounded-full border-[#ebe4dc] bg-white px-5 text-sm font-semibold text-[#3d2b22] hover:bg-[#f5efe8]">
                    Message
                </a>
                @if ($isFollowing)
                    <form method="POST" action="{{ route('profile.unfollow', $user->username) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn rounded-full border-[#ebe4dc] bg-white px-6 text-sm font-semibold text-[#3d2b22] hover:bg-[#f5efe8]">
                            Following
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('profile.follow', $user->username) }}">
                        @csrf
                        <button type="submit" class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22]">
                            Follow
                        </button>
                    </form>
                @endif
            @endif
        </div>
    </div>
</section>
