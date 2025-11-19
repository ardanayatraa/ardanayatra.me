<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    
    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#000000">
    <meta name="description" content="Portfolio musik dan coding I Made Ardana Yatra">
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Tridanta Studio">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900">
                    Tridanta Studio
                </a>
                @php
                    $currentRoute = request()->route() ? request()->route()->getName() : '';
                    $pageTitle = 'Siapa Saya? Yuk Kenalan';
                    $shortTitle = '👋';
                    
                    if ($currentRoute && str_contains($currentRoute, 'news')) {
                        $pageTitle = 'FastRead';
                        $shortTitle = 'FR';
                    } elseif ($currentRoute && str_contains($currentRoute, 'fretbubble')) {
                        $pageTitle = 'FretBubble';
                        $shortTitle = 'FB';
                    } elseif ($currentRoute && str_contains($currentRoute, 'chord-learning')) {
                        $pageTitle = 'Chord Learning';
                        $shortTitle = 'CL';
                    } elseif ($currentRoute && str_contains($currentRoute, 'metronome')) {
                        $pageTitle = 'Metronome';
                        $shortTitle = 'MT';
                    } elseif ($currentRoute && str_contains($currentRoute, 'invoicego')) {
                        $pageTitle = 'InvoiceGo';
                        $shortTitle = 'IG';
                    }
                @endphp
                
                <button onclick="openAboutModal()" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-black transition">
                    <span class="hidden sm:inline">{{ $pageTitle }}</span>
                    <span class="sm:hidden">{{ $shortTitle }}</span>
                </button>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>

    <!-- PWA Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then((registration) => {
                        console.log('Service Worker registered:', registration);
                    })
                    .catch((error) => {
                        console.log('Service Worker registration failed:', error);
                    });
            });
        }
    </script>
</body>
</html>
