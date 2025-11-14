<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Tridanta Studio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo/Title -->
            <div class="text-center mb-8">
                <div class="inline-block mb-4">
                    <div class="w-20 h-20 bg-white border-4 border-white flex items-center justify-center text-black text-3xl font-bold">
                        TS
                    </div>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">Tridanta Studio</h1>
                <p class="text-gray-400">Admin Login</p>
            </div>

            <!-- Login Card -->
            <div class="bg-white p-8 shadow-2xl">
                <!-- Session Status -->
                @if (session('status'))
                    <div class="mb-4 p-3 bg-green-50 border-l-4 border-green-600 text-green-800 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-bold text-gray-900 mb-2">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                               class="w-full px-4 py-3 border-2 border-gray-300 focus:border-black focus:ring-0 transition">
                        @error('email')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-900 mb-2">Password</label>
                        <input id="password" type="password" name="password" required
                               class="w-full px-4 py-3 border-2 border-gray-300 focus:border-black focus:ring-0 transition">
                        @error('password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="w-4 h-4 border-gray-300 text-black focus:ring-black">
                        <label for="remember_me" class="ml-2 text-sm text-gray-700">Remember me</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full px-6 py-3 bg-black text-white font-bold hover:bg-gray-800 transition uppercase tracking-wide">
                        Login
                    </button>
                </form>
            </div>

            <!-- Back to Home -->
            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-white transition text-sm inline-flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
