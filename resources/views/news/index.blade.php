<x-layouts.app>
    <div class="min-h-screen bg-black py-8 px-4">
        <div class="container mx-auto max-w-7xl">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white mb-2">Tridanta FastRead</h1>
                <p class="text-gray-400">Baca cepat, dapat ilmu yang berguna</p>
            </div>

            <!-- Search & Filter -->
            <div class="bg-white rounded-xl p-4 mb-6 border-2 border-black shadow-lg">
                <form action="{{ route('news.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..."
                           class="flex-1 bg-white border-2 border-black text-black rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black">
                    
                    <select name="category" class="bg-white border-2 border-black text-black rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                                {{ $category->name }} ({{ $category->posts_count }})
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-8 rounded-lg transition">
                        Cari
                    </button>
                </form>
            </div>

            <!-- News Grid -->
            @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($news as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="group">
                            <div class="bg-white border-2 border-black rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300 h-full flex flex-col">
                                @if($article->image)
                                    <div class="relative w-full h-48 overflow-hidden bg-gray-100">
                                        <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" 
                                             class="w-full h-full object-cover object-center grayscale group-hover:grayscale-0 transition-all duration-300">
                                        @if($article->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="inline-block px-3 py-1 bg-black text-white text-xs font-bold">{{ $article->category->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="relative h-48 bg-gray-900 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                        @if($article->category)
                                            <div class="absolute top-4 left-4">
                                                <span class="inline-block px-3 py-1 bg-white text-black text-xs font-bold">{{ $article->category->name }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                
                                <div class="p-4 flex-1 flex flex-col">
                                    <h3 class="text-lg font-bold mb-2 group-hover:underline line-clamp-2">{{ $article->title }}</h3>
                                    
                                    @if($article->excerpt)
                                        <p class="text-gray-600 text-sm mb-3 line-clamp-2 flex-1">{{ $article->excerpt }}</p>
                                    @endif
                                    
                                    <div class="flex items-center justify-between text-xs text-gray-500 mt-auto pt-3 border-t">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>Ardana Yatra</span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span>{{ $article->formatted_date }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $news->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-gray-700 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-400">Tidak ada artikel ditemukan</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
