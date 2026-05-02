<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign In — HerSpace</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,600&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --cream:       #F5F0E8;
            --warm-white:  #FDFCF9;
            --rust:        #A0513A;
            --rust-light:  #C07358;
            --rust-hover:  #8B4530;
            --brown-dark:  #2E1F1A;
            --brown-mid:   #5C3D2E;
            --taupe:       #B8A99A;
            --field-bg:    #EDEBE5;
            --border:      rgba(160,81,58,0.15);
        }

        html, body {
            height: 100%;
            font-family: 'DM Sans', sans-serif;
            background: var(--cream);
            color: var(--brown-dark);
        }

        .page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background:
                radial-gradient(ellipse 60% 50% at 20% 80%, rgba(192,115,88,0.12) 0%, transparent 60%),
                radial-gradient(ellipse 50% 40% at 80% 20%, rgba(160,81,58,0.08) 0%, transparent 55%),
                var(--cream);
        }

        .card {
            display: grid;
            grid-template-columns: 1fr 1fr;
            width: 100%;
            max-width: 960px;
            background: var(--warm-white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 48px rgba(46,31,26,0.10);
            animation: fadeUp 0.5s ease both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Left panel ── */
        .panel-left {
            background:
                radial-gradient(ellipse 80% 60% at 30% 90%, rgba(192,115,88,0.20) 0%, transparent 65%),
                radial-gradient(ellipse 60% 50% at 80% 10%, rgba(160,81,58,0.10) 0%, transparent 55%),
                var(--cream);
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 520px;
        }

        .logo {
            font-family: 'Playfair Display', serif;
            font-style: italic;
            font-weight: 700;
            font-size: 2rem;
            color: var(--rust);
            line-height: 1;
            margin-bottom: 4px;
        }

        .tagline {
            font-size: 0.68rem;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: var(--brown-mid);
            font-weight: 500;
        }

        .quote-block {
            margin-top: auto;
        }

        .quote-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.45rem;
            font-weight: 700;
            line-height: 1.4;
            color: var(--brown-dark);
        }

        .quote-text em {
            font-style: italic;
            color: var(--rust);
        }

        .quote-text .olive {
            color: #7A8A5C;
            font-style: italic;
        }

        .author {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .author-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--rust-light);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            flex-shrink: 0;
        }

        .author-name {
            font-weight: 500;
            font-size: 0.9rem;
            color: var(--brown-dark);
        }

        .author-role {
            font-size: 0.78rem;
            color: var(--taupe);
            margin-top: 1px;
        }

        /* ── Right panel ── */
        .panel-right {
            padding: 3rem 2.75rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .welcome-heading {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--brown-dark);
            margin-bottom: 0.4rem;
        }

        .welcome-sub {
            font-size: 0.9rem;
            color: var(--taupe);
            margin-bottom: 2rem;
        }

        .field-group {
            margin-bottom: 1.2rem;
        }

        .field-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 0.45rem;
        }

        .field-label {
            font-size: 0.7rem;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--brown-mid);
        }

        .forgot-link {
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--rust);
            text-decoration: none;
            transition: color 0.15s;
        }

        .forgot-link:hover { color: var(--rust-hover); }

        .field-input {
            width: 100%;
            height: 50px;
            background: var(--field-bg);
            border: 1.5px solid transparent;
            border-radius: 10px;
            padding: 0 16px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--brown-dark);
            transition: border-color 0.2s, background 0.2s;
            outline: none;
        }

        .field-input::placeholder { color: var(--taupe); }

        .field-input:focus {
            border-color: var(--rust-light);
            background: #fff;
        }

        @if($errors->has('email') || $errors->has('password'))
        .field-input.error { border-color: #C0392B; }
        @endif

        .remember {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 1.1rem 0 1.5rem;
            cursor: pointer;
        }

        .remember input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--rust);
            cursor: pointer;
        }

        .remember-label {
            font-size: 0.85rem;
            color: var(--brown-mid);
            user-select: none;
        }

        .btn-signin {
            width: 100%;
            height: 52px;
            background: linear-gradient(135deg, var(--rust-light) 0%, var(--rust) 100%);
            border: none;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 500;
            color: #fff;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
            letter-spacing: 0.02em;
        }

        .btn-signin:hover  { opacity: 0.92; }
        .btn-signin:active { transform: scale(0.99); }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 1.6rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        .divider-text {
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--taupe);
            white-space: nowrap;
        }

        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 46px;
            background: var(--warm-white);
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--brown-dark);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.15s, border-color 0.15s;
        }

        .btn-social:hover {
            background: var(--field-bg);
            border-color: var(--taupe);
        }

        .social-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .register-line {
            text-align: center;
            margin-top: 1.6rem;
            font-size: 0.85rem;
            color: var(--taupe);
        }

        .register-link {
            color: var(--rust);
            font-weight: 500;
            text-decoration: none;
            transition: color 0.15s;
        }

        .register-link:hover { color: var(--rust-hover); }

        .error-msg {
            background: #FDF0EE;
            border: 1px solid #E8B4AA;
            color: #8B2E1F;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.82rem;
            margin-bottom: 1.2rem;
        }

        /* ── Responsive ── */
        @media (max-width: 680px) {
            .page { padding: 1rem; }
            .card { grid-template-columns: 1fr; }
            .panel-left {
                min-height: auto;
                padding: 2rem 1.75rem 1.5rem;
            }
            .quote-block { margin-top: 1.5rem; }
            .panel-right { padding: 2rem 1.75rem; }
        }
    </style>
</head>
<body>
<div class="page">
    <div class="card">

        {{-- Left panel --}}
        <div class="panel-left">
            <div>
                <div class="logo">HerSpace</div>
                <div class="tagline">The Editorial Sanctuary</div>
            </div>

            <div class="quote-block">
                <p class="quote-text">
                    "A curated space designed for your
                    <em>clarity</em> and <span class="olive">growth</span>."
                </p>
               <div class="author">
                    <div class="author-avatar">EV</div>
                    <div>
                        <div class="author-name">Elena Vance</div>
                        <div class="author-role">Chief Curator, HerSpace</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right panel --}}
        <div class="panel-right">
            <h1 class="welcome-heading">Welcome back</h1>
            <p class="welcome-sub">Please enter your details to find your rhythm.</p>

            {{-- Session / validation errors --}}
            @if ($errors->any())
                <div class="error-msg">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="error-msg" style="background:#EEF5EE; border-color:#A4C9A4; color:#2E5A2E;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.perform') }}">
                @csrf

                <div class="field-group">
                    <div class="field-header">
                        <label class="field-label" for="email">Email / Username</label>
                    </div>
                    <input
                        class="field-input @error('email') error @enderror"
                        type="text"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="hello@herspace.com"
                        autocomplete="email"
                        autofocus
                    >
                </div>

                <div class="field-group">
                    <div class="field-header">
                        <label class="field-label" for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a class="forgot-link" href="{{ route('password.request') }}">Forgot Password?</a>
                        @endif
                    </div>
                    <input
                        class="field-input @error('password') error @enderror"
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        autocomplete="current-password"
                    >
                </div>

                <label class="remember">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="remember-label">Remember me for 30 days</span>
                </label>

                <button type="submit" class="btn-signin">Sign In</button>
            </form>

            <div class="divider">
                <span class="divider-text">or continue with</span>
            </div>

            <div class="social-grid">
                <a href="{{ \Illuminate\Support\Facades\Route::has('auth.google') ? route('auth.google') : '#' }}" class="btn-social">
                    <svg class="social-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    Google
                </a>
                <a href="{{ \Illuminate\Support\Facades\Route::has('auth.apple') ? route('auth.apple') : '#' }}" class="btn-social">
                    <svg class="social-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.7 9.05 7.4c1.42.07 2.41.74 3.23.8.98-.19 1.93-.88 2.95-.94 1.24-.07 2.42.51 3.07 1.37-2.76 1.62-2.28 5.21.5 6.13-.56 1.56-1.35 3.1-1.75 5.52zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                    </svg>
                    Apple
                </a>
            </div>

            @if (Route::has('register'))
                <p class="register-line">
                    New to the sanctuary?
                    <a class="register-link" href="{{ route('register') }}">Register</a>
                </p>
            @endif
        </div>

    </div>
</div>
</body>
</html>