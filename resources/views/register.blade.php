<x-layouts.auth
    title="{{ __('Register') }} — HerSpace"
    :hero-title="__('Begin your journey')"
    :hero-subtitle="__('Create a space that\'s uniquely yours.')"
>
    <form
        method="POST"
        action="{{ route('register.perform') }}"
        id="register-form"
        enctype="multipart/form-data"
        class="space-y-10"
        novalidate
    >
        @csrf

        <fieldset class="fieldset mb-5 border-0 p-0">
            <x-auth.section-heading step="1" :heading="__('Identity')" heading-id="sec-identity" />

            <div class="mb-6 flex flex-col items-center">
                <div class="auth-photo-ring">
                    <label for="avatar" class="flex h-full w-full cursor-pointer items-center justify-center rounded-full">
                        <svg class="h-9 w-9" viewBox="0 0 24 24" fill="none" stroke="#8A8580" stroke-width="1.5" aria-hidden="true">
                            <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                            <circle cx="12" cy="13" r="4" />
                        </svg>
                    </label>
                    <button type="button" class="auth-photo-edit" id="avatar-trigger" aria-label="{{ __('Choose profile photo') }}">
                        <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z" />
                        </svg>
                    </button>
                </div>
                <input type="file" id="avatar" name="avatar" accept="image/*" class="auth-file-hidden" tabindex="-1" />
                <span class="mt-2.5 text-[0.65rem] font-semibold uppercase tracking-[0.14em] text-[#6B6560]">{{ __('Upload profile photo') }}</span>
            </div>

            <div class="auth-grid-2">
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="username">{{ __('Username') }}</label>
                    <div
                        class="auth-input-shell @error('username') has-server-err @enderror"
                        id="username-shell"
                        data-server-err="{{ $errors->has('username') ? '1' : '' }}"
                    >
                        <input
                            id="username"
                            name="username"
                            type="text"
                            value="{{ old('username') }}"
                            placeholder="e.g. blooming_willow"
                            autocomplete="username"
                            pattern="[a-z0-9_]{3,32}"
                            title="{{ __('3–32 characters: lowercase letters, numbers, underscores') }}"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                        />
                        <span class="auth-input-icon auth-icon-ok" aria-hidden="true">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" fill="#E8F5F0" />
                                <path d="M8 12l2.5 2.5L16 9" stroke="#2D8A6E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    <p id="username-hint" class="mt-1 hidden text-xs font-medium text-[#2E7D7D]">{{ __('That name is available!') }}</p>
                    {{-- @error('username')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror --}}
                    <x-error name="username" />
                </div>
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="email">{{ __('Email') }}</label>
                    <div
                        class="auth-input-shell @error('email') has-server-err @enderror"
                        id="email-shell"
                        data-server-err="{{ $errors->has('email') ? '1' : '' }}"
                    >
                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            placeholder="hello@herspace.com"
                            autocomplete="email"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                        />
                        <span class="auth-input-icon auth-icon-ok" aria-hidden="true">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" fill="#E8F5F0" />
                                <path d="M8 12l2.5 2.5L16 9" stroke="#2D8A6E" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </div>
                    {{-- @error('email')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror --}}
                    <x-error name="email" />
                </div>
            </div>
        </fieldset>

        <fieldset class="fieldset mb-5 border-0 p-0">
            <x-auth.section-heading step="2" :heading="__('Security')" heading-id="sec-security" />
            <div class="auth-grid-2">
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="password">{{ __('Password') }}</label>
                    <div
                        class="auth-input-shell @error('password') has-server-err @enderror"
                        id="password-shell"
                        data-server-err="{{ $errors->has('password') ? '1' : '' }}"
                    >
                        <input
                            id="password"
                            name="password"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                        />
                        <span class="auth-input-icon auth-icon-warn" aria-hidden="true">
                            <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none">
                                <circle cx="12" cy="12" r="10" fill="#FDECEC" />
                                <path d="M12 7v5M12 16h.01" stroke="#C73E3E" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </span>
                    </div>
                    <p id="password-hint" class="mt-1 hidden text-xs text-error">{{ __('Password is too weak. Try adding symbols.') }}</p>
                    {{-- @error('password')
                        <p class="mt-1 text-xs text-error">{{ $message }}</p>
                    @enderror --}}
                    <x-error name="password" />
                </div>
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="password_confirmation">{{ __('Confirm password') }}</label>
                    <div class="auth-input-shell">
                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            placeholder="••••••••"
                            autocomplete="new-password"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                        />
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset class="fieldset mb-5 border-0 p-0">
            <x-auth.section-heading step="3" :heading="__('Personal details')" heading-id="sec-personal" />
            <div class="auth-grid-2">
                    <div class="fieldset mb-0">
                        <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="first_name">
                            {{ __('First name') }}
                        </label>
                        <div class="auth-input-shell">
                            <input
                                id="first_name"
                                name="first_name"
                                type="text"
                                value="{{ old('first_name') }}"
                                placeholder="Maria"
                                autocomplete="given-name"
                                class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                            />
                        </div>
                        <x-error name="first_name" />
                    </div>
                    <div class="fieldset mb-0">
                        <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="last_name">
                            {{ __('Last name') }}
                        </label>
                        <div class="auth-input-shell">
                            <input
                                id="last_name"
                                name="last_name"
                                type="text"
                                value="{{ old('last_name') }}"
                                placeholder="Ivanova"
                                autocomplete="family-name"
                                class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                            />
                        </div>
                        <x-error name="last_name" />
                    </div>
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="phone">{{ __('Phone number') }}</label>
                    <div class="auth-input-shell">
                        <input
                            id="phone"
                            name="phone"
                            type="tel"
                            value="{{ old('phone') }}"
                            placeholder="+1 (555) 000-0000"
                            autocomplete="tel"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                        />
                    </div>
                </div>
                <div class="fieldset mb-0">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="birthdate">{{ __('Date of birth') }}</label>
                    <div class="auth-input-shell">
                        <input
                            id="birthdate"
                            name="birthdate"
                            type="date"
                            value="{{ old('birthdate') }}"
                            class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] focus:border-[#3A9B9B] focus:outline-none"
                        />
                    </div>
                </div>
            </div>

            <div class="fieldset mt-4 mb-0">
                <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="city_id">{{ __('City') }}</label>
                <div class="auth-input-shell auth-select-wrap @error('city_id') has-server-err @enderror" id="city-select-wrap">
                    <select
                        id="city_id"
                        name="city_id"
                        required
                        {{-- class="select select-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] focus:border-[#3A9B9B] focus:outline-none" --}}
                    >
                        <option value="">Select your city</option>
                        @if ($selectedCity ?? null)
                            <option value="{{ $selectedCity->id }}" selected>
                                {{ $selectedCity->name }}@if ($selectedCity->country), {{ $selectedCity->country->name }}@endif
                            </option>
                        @endif
                    </select>
                </div>
                {{-- @error('city_id')
                    <p class="mt-1 text-xs text-error">{{ $message }}</p>
                @enderror --}}
                <x-error name="city_id" />
            </div>

         



            <div class="fieldset mt-4 mb-0">
                <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="bio">{{ __('Tell us about yourself') }}</label>
                <div class="auth-input-shell">
                    <textarea
                        id="bio"
                        name="bio"
                        rows="4"
                        placeholder="{{ __('I love morning coffee, digital art, and finding secret gardens...') }}"
                        class="textarea textarea-bordered min-h-28 w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                    >{{ old('bio') }}</textarea>
                </div>
            </div>
        </fieldset>

        <button type="submit" class="btn w-full rounded-full border-0 bg-gradient-to-br from-[#E8B4BC] to-[#C895A3] py-6 text-base font-semibold text-white shadow-lg hover:opacity-95">
            {{ __('Complete Registration') }}
        </button>
    </form>

    <x-slot:footer>
        @if (Route::has('login'))
            {{ __('Already have an account?') }}
            <a class="link font-semibold text-[#2E7D7D] no-underline hover:underline" href="{{ route('login') }}">{{ __('Sign In') }}</a>
        @endif
    </x-slot:footer>
</x-layouts.auth>

<script>
(function () {
    // ── Avatar preview ──
var avatar = document.getElementById('avatar');
var avatarTrigger = document.getElementById('avatar-trigger');
var avatarLabel = document.querySelector('label[for="avatar"]');

if (avatar && avatarTrigger) {
    avatarTrigger.addEventListener('click', function () { avatar.click(); });
    
    avatar.addEventListener('change', function () {
        var file = this.files[0];
        if (!file) return;
        
        var reader = new FileReader();
        reader.onload = function (e) {
            // Заменяме SVG иконката със снимката
            avatarLabel.innerHTML = '<img src="' + e.target.result + '" alt="Profile photo" style="width:100%;height:100%;object-fit:cover;border-radius:9999px;">';
        };
        reader.readAsDataURL(file);
    });
}

    var userShell = document.getElementById('username-shell');
    var userInput = document.getElementById('username');
    var userHint  = document.getElementById('username-hint');
    var emailShell = document.getElementById('email-shell');
    var emailInput = document.getElementById('email');
    var passShell  = document.getElementById('password-shell');
    var passInput  = document.getElementById('password');
    var passHint   = document.getElementById('password-hint');

    function syncUser() {
        if (!userShell || !userInput) return;
        if (userShell.getAttribute('data-server-err')) return;
        var ok = /^[a-z0-9_]{3,32}$/.test(userInput.value.trim());
        userShell.classList.toggle('show-ok', ok);
        if (userHint) userHint.classList.toggle('hidden', !ok);
    }
    function syncEmail() {
        if (!emailShell || !emailInput) return;
        if (emailShell.getAttribute('data-server-err')) { emailShell.classList.remove('show-ok'); return; }
        emailShell.classList.toggle('show-ok', !!emailInput.value && emailInput.checkValidity());
    }
    function passwordWeak(p) {
        return !p || p.length < 8 || !/[0-9]/.test(p) || !/[^a-zA-Z0-9]/.test(p);
    }
    function syncPass() {
        if (!passShell || !passInput) return;
        if (passShell.getAttribute('data-server-err')) {
            passShell.classList.remove('has-error', 'show-warn');
            if (passHint) passHint.classList.add('hidden');
            return;
        }
        var weak = passInput.value.length > 0 && passwordWeak(passInput.value);
        passShell.classList.toggle('has-error', weak);
        passShell.classList.toggle('show-warn', weak);
        if (passHint) passHint.classList.toggle('hidden', !weak);
    }
    if (userInput) { userInput.addEventListener('input', syncUser); syncUser(); }
    if (emailInput) { emailInput.addEventListener('input', syncEmail); syncEmail(); }
    if (passInput) { passInput.addEventListener('input', syncPass); syncPass(); }
})();
</script>




