<x-layouts.app>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-4">Kirim Pesan</h1>
            <p class="text-gray-600 mb-8">
                Bagikan pemikiran, feedback, atau sekedar say hi! Pesan Anda akan dikirim secara anonim.
            </p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST" class="space-y-6" id="messageForm">
                @csrf

                @php
                    $visitor = \App\Models\Visitor::where('session_id', session()->getId())->first();
                    $hasName = $visitor && $visitor->name;
                @endphp

                @if(!$hasName && !auth()->check())
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Anda <span class="text-red-500">*</span></label>
                    <input 
                        type="text" 
                        name="name" 
                        required 
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Siapa nama Anda?"
                        value="{{ old('name') }}"
                    >
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Kami perlu tahu siapa yang mengirim pesan 😊</p>
                </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pesan Anda</label>
                    <textarea 
                        name="message" 
                        rows="6" 
                        required 
                        maxlength="1000"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Tulis pesan Anda di sini..."
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <strong>Catatan:</strong> Anda bisa mengirim maksimal 5 pesan per hari. Mohon kirim pesan yang sopan dan membangun.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 px-6 py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-800 transition">
                        Kirim Pesan
                    </button>
                    <a href="{{ route('home') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
