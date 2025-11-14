<x-layouts.app>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-4xl font-bold mb-8">All Projects</h1>

        @if($posts->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="group">
                        <div class="bg-white rounded-lg overflow-hidden shadow hover:shadow-xl transition">
                            @if($post->cover_type === 'image' && $post->cover_image)
                                <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600"></div>
                            @endif
                            <div class="p-6">
                                <span class="text-xs text-blue-600 font-semibold">{{ $post->category->name }}</span>
                                <h3 class="text-xl font-bold mt-2 group-hover:text-blue-600 transition">{{ $post->title }}</h3>
                                <p class="text-gray-600 mt-2 line-clamp-2">{{ Str::limit($post->description, 100) }}</p>
                                <div class="mt-4 text-sm text-gray-500">
                                    {{ $post->published_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500 text-lg">No projects found.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
