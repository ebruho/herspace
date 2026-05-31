@props([
    'title' => 'HerSpace',
    'heroTitle',
    'heroSubtitle' => null,
])


<x-layout :title="$title" :show-footer="false">
    @include('components.auth.auth-skin')

    <div
        class="min-h-screen bg-[#F7F4EF] bg-[radial-gradient(ellipse_50%_40%_at_90%_10%,rgba(232,180,188,0.12),transparent_55%),radial-gradient(ellipse_45%_35%_at_8%_85%,rgba(58,155,155,0.08),transparent_50%)] px-4 py-8 sm:px-6"
    >
        <div class="mx-auto grid max-w-[1120px] items-start gap-10 lg:grid-cols-[minmax(0,1fr)_280px]">
            <div class="mx-auto w-full min-w-0 max-w-[640px]">
                <x-auth.top-bar />
                <x-auth.hero :title="$heroTitle" :subtitle="$heroSubtitle" />
                <x-auth.flash-alerts /> 

                {{ $slot }}

                @isset($footer)
                    <div class="mt-6 text-center text-sm text-[#6B6560]">
                        {{ $footer }}
                    </div>
                @endisset

                <x-auth.decor-dots class="mt-10" />
            </div>

            <aside class="sticky top-6 hidden flex-col gap-5 lg:flex" aria-label="Inspiration">
                <x-auth.decor-sidebar />
            </aside>
        </div>
    </div>
    @isset($scripts)
        {{ $scripts }}
    @endisset
     @stack('scripts')
</x-layout>


{{-- 
<script>
(function () {
    var avatar = document.getElementById('avatar');
    var avatarTrigger = document.getElementById('avatar-trigger');
    if (avatar && avatarTrigger) {
        avatarTrigger.addEventListener('click', function () { avatar.click(); });
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

    // ── City TomSelect ──
    var cityEl = document.getElementById('city_id');
    if (!cityEl || typeof TomSelect === 'undefined') return;

    var observer = new MutationObserver(function() {
        var spinner = document.querySelector('#city-select-wrap .spinner');
        if (spinner) spinner.style.display = 'none';
    });
    observer.observe(document.getElementById('city-select-wrap'), { childList: true, subtree: true });

    new TomSelect(cityEl, {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        loadThrottle: 400,
        load: function (query, callback) {
            if (query.length < 2) return callback();
            fetch('/cities/search?q=' + encodeURIComponent(query))
                .then(function (r) { return r.json(); })
                .then(function (data) { callback(data); })
                .catch(function () { callback(); });
        }
    });
})();
</script> --}}

{{-- <script>
    console.log('script loaded');
    document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM ready');
    var cityEl = document.getElementById('city_id');
    console.log('cityEl:', cityEl);
    console.log('TomSelect:', typeof TomSelect);

    if (!cityEl || typeof TomSelect === 'undefined') {
        console.log('RETURNING EARLY');
        return;
    }

    new TomSelect(cityEl, {
        valueField: 'id',
        labelField: 'text',
        searchField: 'text',
        load: function (query, callback) {
            fetch('/cities/search?q=' + encodeURIComponent(query))
                .then(function (r) { return r.json(); })
                .then(function (data) { callback(data); })
                .catch(function () { callback(); });
        }
    });
        // Наблюдаваме DOM за spinner
    var observer = new MutationObserver(function(mutations) {
        var spinner = document.querySelector('#city-select-wrap .spinner');
        if (spinner) spinner.style.display = 'none';
    });

    observer.observe(document.getElementById('city-select-wrap'), {
        childList: true,
        subtree: true
    });
});
</script> --}}
