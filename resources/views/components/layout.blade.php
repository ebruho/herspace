@props([
    'title' => 'HerSpace',
    'showFooter' => true,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="cupcake">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    {{-- <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet"> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --font-sans: "DM Sans", ui-sans-serif, system-ui, sans-serif;
            --font-serif: "Playfair Display", ui-serif, Georgia, serif;
        }
        body { font-family: var(--font-sans); }
        .font-serif { font-family: var(--font-serif); }

        .ts-wrapper { width: 100%; }
        .ts-control {
            background: #EBE8E2 !important;
            border: 1.5px solid transparent !important;
            border-radius: 1.5rem !important;
            padding: 0.875rem 1rem !important;
            min-height: 52px !important;
            font-size: 0.9rem !important;
            font-family: 'DM Sans', sans-serif !important;
        }
        .ts-wrapper.focus .ts-control {
            background: #FDFCF9 !important;
            border-color: #3A9B9B !important;
            box-shadow: 0 0 0 3px rgba(58,155,155,0.15) !important;
        }
        #city-select-wrap .ts-wrapper .spinner {
            width: 16px !important;
            height: 16px !important;
            border: 2px solid rgba(58,155,155,0.2) !important;
            border-top-color: #3A9B9B !important;
        }
        #city-select-wrap .ts-dropdown-content .spinner {
            display: none !important;
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-screen antialiased text-base-content">
    <main>
        {{ $slot }}
    </main>

    @if ($showFooter)
        <footer class="footer footer-center border-base-300 border-t p-6 text-base-content/70 text-sm">
            <p>&copy; {{ date('Y') }} HerSpace</p>
        </footer>
    @endif

    {{-- <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script> --}}
    @stack('scripts')

</body>
</html>
