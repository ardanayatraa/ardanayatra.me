<x-layouts.admin>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold">Posts</h1>
                <p class="text-gray-600 text-sm mt-1">Manage your music and coding posts</p>
            </div>
            <a href="{{ route('admin.posts.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Create Post</span>
            </a>
        </div>

        <!-- Search & Filter -->
        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 space-y-4">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.posts.index') }}" class="flex gap-2">
                <input type="hidden" name="category" value="{{ request('category') }}">
                <div class="flex-1 relative">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}" 
                           placeholder="Search posts by title or description..." 
                           class="w-full px-4 py-3 pl-10 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.posts.index', ['category' => request('category')]) }}" 
                       class="px-6 py-3 border-2 border-gray-200 rounded-lg hover:border-black transition font-semibold">
                        Clear
                    </a>
                @endif
            </form>

            <!-- Category Filter -->
            <div class="flex flex-wrap items-center gap-3 pt-3 border-t-2 border-gray-100">
                <span class="text-sm font-semibold text-gray-700">Filter:</span>
                <a href="{{ route('admin.posts.index', ['search' => request('search')]) }}" 
                   class="px-4 py-2 text-sm font-medium rounded-lg transition {{ !request('category') ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    All Posts
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('admin.posts.index', ['category' => $category->slug, 'search' => request('search')]) }}" 
                       class="px-4 py-2 text-sm font-medium rounded-lg transition {{ request('category') == $category->slug ? 'bg-black text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Posts Grid (Mobile-friendly) -->
        <div class="grid grid-cols-1 gap-4">
            @forelse($posts as $post)
                <div class="bg-white border-2 border-gray-200 rounded-lg hover:border-black transition">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded">
                                        {{ $post->category->name }}
                                    </span>
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $post->is_published ? 'bg-black text-white' : 'bg-gray-200 text-gray-700' }}">
                                        {{ $post->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </div>
                                <h3 class="text-lg font-bold mb-1 truncate">{{ $post->title }}</h3>
                                <p class="text-sm text-gray-600 line-clamp-2 mb-3">{{ Str::limit($post->description, 100) }}</p>
                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    <span>•</span>
                                    <span>{{ $post->cover_type === 'embed' ? 'Video' : 'Image' }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-center gap-2 mt-4 pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.posts.edit', $post) }}" 
                               class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-black text-white text-sm font-medium rounded hover:bg-gray-800 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Edit
                            </a>
                            <a href="{{ route('posts.show', $post->slug) }}" target="_blank"
                               class="inline-flex items-center justify-center px-4 py-2 border-2 border-gray-200 text-sm font-medium rounded hover:border-black transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        onclick="return confirm('Are you sure you want to delete this post?')"
                                        class="inline-flex items-center justify-center px-4 py-2 border-2 border-red-200 text-red-600 text-sm font-medium rounded hover:border-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white border-2 border-gray-200 rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold mb-2">No posts yet</h3>
                    <p class="text-gray-600 mb-4">Get started by creating your first post</p>
                    <a href="{{ route('admin.posts.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Create Post
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-6">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</x-layouts.admin>
