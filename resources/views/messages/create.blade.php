<x-layouts.app>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-4">Send Anonymous Message</h1>
            <p class="text-gray-600 mb-8">
                Share your thoughts, feedback, or just say hi! Your message will be sent anonymously.
            </p>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-700 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea 
                        name="message" 
                        rows="6" 
                        required 
                        maxlength="1000"
                        class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Type your message here..."
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-sm text-gray-500">Maximum 1000 characters</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <p class="text-sm text-yellow-800">
                        <strong>Note:</strong> You can send up to 5 messages per hour. Please be respectful and constructive.
                    </p>
                </div>

                <div class="flex space-x-4">
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        Send Message
                    </button>
                    <a href="{{ route('home') }}" class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-lg hover:bg-gray-300 transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
