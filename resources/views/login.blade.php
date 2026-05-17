<x-layouts.auth title="{{ __('Sign In') }} — HerSpace" :hero-title="__('Welcome back')" :hero-subtitle="__('Please enter your details to find your rhythm.')">
    <form method="POST" action="{{ route('login.perform') }}" class="space-y-6">
        @csrf

        <fieldset class="fieldset mb-0 border-0 p-0">
            <x-auth.section-heading step="1" :heading="__('Sign in')" heading-id="sec-signin" />

            <div class="fieldset mb-4">
                <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="email">{{ __('Email / username') }}</label>
                <div class="auth-input-shell @error('email') has-error has-server-err @enderror">
                    <input
                        id="email"
                        name="email"
                        type="text"
                        value="{{ old('email') }}"
                        placeholder="hello@herspace.com"
                        autocomplete="username"
                        autofocus
                        class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                    />
                </div>
            </div>

            <div class="fieldset mb-4">
                <div class="mb-1 flex items-baseline justify-between gap-2">
                    <label class="fieldset-label text-xs font-semibold uppercase tracking-wider text-[#6B6560]" for="password">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a class="link link-hover text-xs font-semibold text-[#2E7D7D] no-underline hover:underline" href="{{ route('password.request') }}">{{ __('Forgot password?') }}</a>
                    @endif
                </div>
                <div class="auth-input-shell @error('password') has-error has-server-err @enderror">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                        class="input input-bordered w-full rounded-3xl border-transparent bg-[#EBE8E2] py-3.5 pr-4 text-[#3A3532] placeholder:text-[#9A948C] focus:border-[#3A9B9B] focus:outline-none"
                    />
                </div>
            </div>

            <label class="label mb-6 cursor-pointer justify-start gap-3 py-0">
                <input type="checkbox" name="remember" class="checkbox checkbox-sm border-[rgba(58,155,155,0.45)] [--chkfg:white] [--chkbg:#3A9B9B]" {{ old('remember') ? 'checked' : '' }} />
                <span class="label-text text-sm text-[#6B6560]">{{ __('Remember me for 30 days') }}</span>
            </label>

            <button type="submit" class="btn w-full rounded-full border-0 bg-gradient-to-br from-[#E8B4BC] to-[#C895A3] py-6 text-base font-semibold text-white shadow-lg hover:opacity-95">
                {{ __('Sign In') }}
            </button>
        </fieldset>
    </form>

    <div class="divider my-8 text-xs font-semibold uppercase tracking-wider text-[#6B6560]">{{ __('or continue with') }}</div>

    <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
        <x-auth.oauth-button
            provider="google"
            :href="\Illuminate\Support\Facades\Route::has('auth.google') ? route('auth.google') : '#'"
            :label="__('Google')"
        />
        <x-auth.oauth-button
            provider="apple"
            :href="\Illuminate\Support\Facades\Route::has('auth.apple') ? route('auth.apple') : '#'"
            :label="__('Apple')"
        />
    </div>

    <x-slot:footer>
        @if (Route::has('register'))
            {{ __('New to HerSpace?') }}
            <a class="link font-semibold text-[#2E7D7D] no-underline hover:underline" href="{{ route('register') }}">{{ __('Create an account') }}</a>
        @endif
    </x-slot:footer>
</x-layouts.auth>
