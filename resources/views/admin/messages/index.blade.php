<x-layouts.admin>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2">Secret Messages</h1>
            <p class="text-gray-600">Messages grouped by visitor</p>
        </div>

        <!-- Visitors List -->
        <div class="space-y-4">
            @forelse($visitors as $visitor)
                <div class="bg-white border-2 border-gray-200 rounded-lg hover:border-gray-300 transition" 
                     x-data="{ expanded: false }">
                    
                    <!-- Visitor Header -->
                    <div @click="expanded = !expanded" 
                         class="p-4 sm:p-6 cursor-pointer flex items-center justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 bg-black text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">
                                    {{ substr($visitor->name, 0, 1) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-lg font-bold truncate">{{ $visitor->name }}</h3>
                                    <p class="text-sm text-gray-600 truncate">{{ $visitor->email }}</p>
                                </div>
                            </div>
                            
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600 ml-13">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $visitor->secret_messages_count }} messages
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $visitor->created_at->diffForHumans() }}
                                </span>
                                @if($visitor->secretMessages->where('is_read', false)->count() > 0)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                        {{ $visitor->secretMessages->where('is_read', false)->count() }} unread
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <svg x-show="!expanded" class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                        <svg x-show="expanded" class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                        </svg>
                    </div>

                    <!-- Messages List -->
                    <div x-show="expanded" 
                         x-transition
                         class="border-t-2 border-gray-200 p-4 sm:p-6 space-y-3 bg-gray-50">
                        @foreach($visitor->secretMessages as $message)
                            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 hover:border-gray-300 transition">
                                <div class="flex items-start justify-between gap-4 mb-3">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs text-gray-500">
                                                {{ $message->created_at->format('M d, Y H:i') }}
                                            </span>
                                            @if(!$message->is_read)
                                                <span class="px-2 py-0.5 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                                                    New
                                                </span>
                                            @endif
                                        </div>
                                        <p class="text-gray-800 leading-relaxed">{{ $message->message }}</p>
                                    </div>
                                    
                                    <form action="{{ route('admin.messages.destroy', $message) }}" 
                                          method="POST" 
                                          onsubmit="return confirm('Delete this message?')"
                                          class="flex-shrink-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="p-2 text-gray-400 hover:text-red-600 transition"
                                                title="Delete message">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-gray-200 rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <h3 class="text-xl font-bold mb-2">No messages yet</h3>
                    <p class="text-gray-600">Messages from visitors will appear here</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.admin>
