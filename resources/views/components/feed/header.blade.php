<header class="fixed inset-x-0 top-0 z-50 h-16 border-b border-[#ebe4dc] bg-[#fdfcf9]/95 backdrop-blur-sm">
    <div class="mx-auto flex h-full max-w-[1600px] items-center gap-4 px-4 lg:px-6">
        <a href="{{ route('home') }}" class="shrink-0 font-serif text-2xl font-semibold italic text-[#5c4033] no-underline">
            HerSpace
        </a>

        <div class="mx-auto hidden max-w-xl flex-1 md:block">
            <label class="relative block">
                <span class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-[#8b7355]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="M20 20l-3-3"/></svg>
                </span>
                <input
                    type="search"
                    placeholder="Search communities, users..."
                    class="input input-bordered w-full rounded-full border-[#ebe4dc] bg-[#f5efe8] py-3 pl-11 pr-4 text-sm text-[#3d2b22] placeholder:text-[#a89888] focus:border-[#e8b4bc] focus:outline-none"
                />
            </label>
        </div>

        <div class="ml-auto flex items-center gap-2 sm:gap-3">
            <a href="#" class="btn btn-ghost btn-circle btn-sm text-[#6b5b52]" aria-label="Messages">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4z"/></svg>
            </a>
            <a href="#" class="btn btn-ghost btn-circle btn-sm relative text-[#6b5b52]" aria-label="Notifications">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                <span class="absolute right-1 top-1 h-2 w-2 rounded-full bg-[#c73e3e]"></span>
            </a>
            <details class="dropdown dropdown-end">
                <summary class="btn btn-ghost btn-circle avatar cursor-pointer list-none p-0">
                    @if (auth()->user()?->profile_picture)
                        <img src="{{ asset('storage/'.auth()->user()->profile_picture) }}" alt="" class="h-9 w-9 rounded-full object-cover" />
                    @else
                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-[#e8b4bc] text-xs font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()?->username ?? auth()->user()?->first_name ?? 'U', 0, 2)) }}
                        </span>
                    @endif
                </summary>
                <ul class="menu dropdown-content z-[60] mt-2 w-44 rounded-2xl border border-[#ebe4dc] bg-white p-2 shadow-lg">
                    <li><a href="{{ route('profile') }}" class="rounded-xl">My Profile</a></li>
                    <li><a href="{{ route('profile', ['username' => auth()->user()->username]) }}" class="rounded-xl">View as Public</a></li>
                    <li><a href="#" class="rounded-xl">Settings</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full rounded-xl text-left">Sign Out</button>
                        </form>
                    </li>
                </ul>
            </details>
        </div>
    </div>
</header>
