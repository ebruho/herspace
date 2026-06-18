<x-layouts.app title="Edit Profile - HerSpace" max-width="max-w-3xl">
    <div class="space-y-5">
        <a href="{{ route('profile') }}"
           class="inline-flex items-center gap-2 text-sm font-medium text-[#8b7355] hover:text-[#3d2b22]">
            <span aria-hidden="true">&larr;</span>
            Back to profile
        </a>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              class="rounded-2xl border border-[#ebe4dc] bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <h1 class="font-serif text-2xl font-semibold text-[#3d2b22]">Edit profile</h1>
                <p class="mt-1 text-sm text-[#8b7355]">Keep your HerSpace identity fresh and easy to recognize.</p>
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div class="sm:col-span-2 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="avatar">Profile photo</label>
                        <input id="avatar" name="avatar" type="file" accept="image/*" class="file-input file-input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                        <x-error name="avatar" />
                    </div>
                    <div>
                        <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="cover_photo">Cover photo</label>
                        <input id="cover_photo" name="cover_photo" type="file" accept="image/*" class="file-input file-input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                        <x-error name="cover_photo" />
                    </div>
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="username">Username</label>
                    <input id="username" name="username" value="{{ old('username', $user->username) }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="username" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="email" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="first_name">First name</label>
                    <input id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="first_name" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="last_name">Last name</label>
                    <input id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="last_name" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="phone">Phone</label>
                    <input id="phone" name="phone" value="{{ old('phone', $user->phone) }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="phone" />
                </div>

                <div>
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="date_of_birth">Date of birth</label>
                    <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', $user->date_of_birth ? \Illuminate\Support\Carbon::parse($user->date_of_birth)->format('Y-m-d') : '') }}" class="input input-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]" />
                    <x-error name="date_of_birth" />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="city_id">City</label>
                    <div id="city-select-wrap">
                        <select id="city_id" name="city_id">
                            <option value="">Select your city</option>
                            @if ($selectedCity)
                                <option value="{{ $selectedCity->id }}" selected>
                                    {{ $selectedCity->name }}@if ($selectedCity->country), {{ $selectedCity->country->name }}@endif
                                </option>
                            @endif
                        </select>
                    </div>
                    <x-error name="city_id" />
                </div>

                <div class="sm:col-span-2">
                    <label class="mb-1 block text-xs font-semibold uppercase tracking-wide text-[#8b7355]" for="bio">Bio</label>
                    <textarea id="bio" name="bio" rows="5" class="textarea textarea-bordered w-full rounded-2xl border-[#ebe4dc] bg-[#f5efe8]">{{ old('bio', $user->bio) }}</textarea>
                    <x-error name="bio" />
                </div>
            </div>

            <div class="mt-6 flex flex-wrap justify-end gap-3">
                <a href="{{ route('profile') }}" class="btn rounded-full border-[#ebe4dc] bg-white px-5 text-sm font-semibold text-[#3d2b22] hover:bg-[#f5efe8]">
                    Cancel
                </a>
                <button type="submit" class="btn rounded-full border-0 bg-[#5c4033] px-6 text-sm font-semibold text-white hover:bg-[#3d2b22]">
                    Save changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
