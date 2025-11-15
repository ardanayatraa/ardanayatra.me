<x-layouts.admin>
    <div class="space-y-8">
        <!-- Header -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ auth()->user()->name }}</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white border-2 border-gray-200 p-6 rounded-lg hover:border-black transition">
                <p class="text-gray-600 text-sm font-medium">Total Posts</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['total_posts'] }}</p>
            </div>

            <div class="bg-white border-2 border-gray-200 p-6 rounded-lg hover:border-black transition">
                <p class="text-gray-600 text-sm font-medium">Published</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['published_posts'] }}</p>
            </div>

            <div class="bg-white border-2 border-gray-200 p-6 rounded-lg hover:border-black transition">
                <p class="text-gray-600 text-sm font-medium">Drafts</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['draft_posts'] }}</p>
            </div>

            <div class="bg-black text-white p-6 rounded-lg">
                <p class="text-gray-300 text-sm font-medium">Unread Messages</p>
                <p class="text-4xl font-bold mt-2">{{ $stats['unread_messages'] }}</p>
            </div>
        </div>

        <!-- Recent Activity Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Posts -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Recent Posts</h2>
                        <a href="{{ route('admin.posts.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all →</a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentPosts as $post)
                            <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex-1 min-w-0">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="font-semibold text-gray-900 hover:text-blue-600 block truncate">
                                        {{ $post->title }}
                                    </a>
                                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                        <span class="px-2 py-0.5 bg-gray-100 rounded text-xs">{{ $post->category->name }}</span>
                                        <span>•</span>
                                        <span>{{ $post->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 text-xs font-medium rounded {{ $post->is_published ? 'bg-black text-white' : 'bg-gray-200 text-gray-700' }}">
                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>No posts yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Recent Messages -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-gray-900">Recent Messages</h2>
                        <a href="{{ route('admin.messages.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all →</a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($recentMessages as $message)
                            <div class="p-4 rounded-lg hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if($message->visitor)
                                                <span class="px-2 py-0.5 bg-gray-900 text-white text-xs font-medium rounded">{{ $message->visitor->name }}</span>
                                                @if(strtoupper($message->visitor->name) === 'MDY')
                                                    <span class="px-2 py-0.5 bg-red-100 text-red-800 text-xs font-medium rounded">ADMIN</span>
                                                @endif
                                            @else
                                                <span class="px-2 py-0.5 bg-gray-200 text-gray-600 text-xs font-medium rounded">Anonymous</span>
                                            @endif
                                            <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm text-gray-700 line-clamp-2">{{ $message->message }}</p>
                                    </div>
                                    <a href="{{ route('admin.messages.show', $message) }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium whitespace-nowrap">View</a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <p>No messages yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
