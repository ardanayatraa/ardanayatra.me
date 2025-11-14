<x-layouts.admin>
    <div class="max-w-3xl">
        <h1 class="text-3xl font-bold mb-6">Message Details</h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-6">
            <div>
                <div class="flex items-center space-x-2 mb-2">
                    @if($message->visitor)
                        <span class="px-3 py-1 text-sm bg-gray-100 text-gray-800 rounded font-medium">From: {{ $message->visitor->name }}</span>
                    @else
                        <span class="px-3 py-1 text-sm bg-gray-100 text-gray-500 rounded">Anonymous</span>
                    @endif
                    <span class="text-sm text-gray-600">{{ $message->created_at->diffForHumans() }}</span>
                </div>
                <div class="p-4 bg-gray-50 rounded">
                    <p class="text-gray-800">{{ $message->message }}</p>
                </div>
            </div>

            @if($message->reply)
                <div>
                    <div class="text-sm text-gray-600 mb-2">Your Reply:</div>
                    <div class="p-4 bg-green-50 rounded">
                        <p class="text-gray-800">{{ $message->reply }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.messages.reply', $message) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reply</label>
                    <textarea name="reply" rows="4" class="w-full border-gray-300 rounded-lg">{{ old('reply', $message->reply) }}</textarea>
                </div>
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    {{ $message->reply ? 'Update Reply' : 'Send Reply' }}
                </button>
            </form>
        </div>
    </div>
</x-layouts.admin>
