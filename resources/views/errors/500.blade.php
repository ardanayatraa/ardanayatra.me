<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>500 - Server Error</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="text-center">
            <!-- 500 Number -->
            <div class="mb-8">
                <h1 class="text-9xl md:text-[12rem] font-bold text-white leading-none">500</h1>
            </div>

            <!-- Message -->
            <div class="mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Waduh...</h2>
                <p class="text-xl md:text-2xl text-white">Ada yang error di server!</p>
            </div>

            <!-- Emoji -->
            <div class="mb-8 text-6xl">
                😵
            </div>

            <!-- Back Button -->
            <div class="space-y-4">
                <a href="{{ route('home') }}" 
                   class="inline-block px-8 py-4 bg-white text-black font-bold hover:bg-gray-200 transition uppercase tracking-wide">
                    Kembali ke Home
                </a>
                
                <div class="text-gray-400 text-sm">
                    Coba refresh atau kembali nanti ya
                </div>
            </div>
        </div>
    </div>
</body>
</html>
