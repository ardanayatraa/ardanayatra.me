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
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('song.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-black transition">
                    Lagu Saya
                    </a>
                    <button onclick="openAboutModal()" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-black transition">
                        👋 Yuk Kenalan
                    </button>
                </div>
            </div>


        </div>
    </nav>



    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-black text-white py-12 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <!-- About -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Tridanta Studio</h3>
                    <p class="text-sm text-gray-400">
                        Portfolio musik dan coding tools yang dibuat sepenuh hati oleh I Made Ardana Yatra.
                    </p>
                </div>
                
                <!-- Features -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Fitur</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('song.index') }}" class="text-gray-400 hover:text-white transition">My Songs</a></li>
                        <li><a href="{{ route('news.index') }}" class="text-gray-400 hover:text-white transition">FastRead</a></li>
                        <li><a href="{{ route('fretbubble.index') }}" class="text-gray-400 hover:text-white transition">FretBubble</a></li>
                        <li><a href="{{ route('chord-learning.index') }}" class="text-gray-400 hover:text-white transition">Chord Learning</a></li>
                        <li><a href="{{ route('metronome.index') }}" class="text-gray-400 hover:text-white transition">Metronome</a></li>
                        <li><a href="{{ route('invoicego.index') }}" class="text-gray-400 hover:text-white transition">InvoiceGo</a></li>
                    </ul>
                </div>
                
                <!-- Connect -->
                <div>
                    <h3 class="text-lg font-bold mb-4">Connect</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="https://www.tiktok.com/@ardanayatraa" target="_blank" class="text-gray-400 hover:text-white transition">TikTok @ardanayatraa</a></li>
                        <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition">About Me</a></li>
                    </ul>
                    <p class="text-xs text-gray-500 mt-4">
                        Made with Code & Music
                    </p>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="border-t border-gray-800 pt-6 text-center">
                <p class="text-sm text-gray-400">
                    © {{ date('Y') }} Tridanta Studio. All rights reserved.
                </p>
                <p class="text-xs text-gray-500 mt-2">
                    Website dibuat sepenuh hati oleh <span class="font-semibold text-gray-300">I Made Ardana Yatra</span>
                </p>
            </div>
        </div>
    </footer>

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
