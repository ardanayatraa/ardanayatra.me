<x-layouts.app>
    <div class="min-h-screen bg-white">
        <!-- Header Image Full Width -->
        @if($article->image)
            <div class="relative w-full h-96 overflow-hidden bg-black">
                <img src="{{ Storage::url($article->image) }}" alt="{{ $article->title }}" 
                     class="w-full h-full object-cover object-center">
            </div>
        @endif

        <!-- Content Container -->
        <div class="container mx-auto max-w-4xl px-4 py-8">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-sm mb-8 text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-black transition">Home</a>
                <span>/</span>
                <a href="{{ route('news.index') }}" class="hover:text-black transition">FastRead</a>
                <span>/</span>
                @if($article->category)
                    <a href="{{ route('news.index', ['category' => $article->category->slug]) }}" class="hover:text-black transition">{{ $article->category->name }}</a>
                    <span>/</span>
                @endif
                <span class="text-black font-medium">{{ Str::limit($article->title, 50) }}</span>
            </nav>

            <!-- Article Content -->
            <article class="bg-white">
                <div>
                    <!-- Meta -->
                    <div class="flex flex-wrap items-center gap-4 mb-6 text-sm text-gray-500">
                        @if($article->category)
                            <span class="inline-block px-3 py-1 bg-black text-white font-bold">{{ $article->category->name }}</span>
                        @endif
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
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $article->views }} views</span>
                        </div>
                        <span>{{ $article->reading_time }}</span>
                    </div>

                    <!-- Title -->
                    <h1 class="text-4xl md:text-5xl font-bold mb-6 text-black">{{ $article->title }}</h1>

                    <!-- Excerpt -->
                    @if($article->excerpt)
                        <p class="text-xl text-gray-700 mb-8 leading-relaxed">{{ $article->excerpt }}</p>
                    @endif

                    <!-- Content -->
                    <div class="prose prose-lg max-w-none prose-headings:text-black prose-p:text-gray-900 prose-a:text-black prose-strong:text-black prose-ul:text-gray-900 prose-ol:text-gray-900">
                        {!! $article->content !!}
                    </div>

                    <!-- Citations / Daftar Pustaka -->
                    @if($article->citations->count() > 0)
                        <div class="mt-12 pt-8 border-t-2 border-gray-300">
                            <h2 class="text-2xl font-bold text-black mb-6">Daftar Pustaka</h2>
                            <div class="space-y-3 text-sm">
                                @foreach($article->citations as $citation)
                                    <div class="pl-6 -indent-6">
                                        <span class="text-gray-700">{!! $citation->formatted_citation !!}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </article>

            <!-- Related News -->
            @if($relatedNews->count() > 0)
                <div class="mt-16 pt-8 border-t-2 border-black">
                    <h2 class="text-3xl font-bold text-black mb-8">Artikel Terkait</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        @foreach($relatedNews as $related)
                            <a href="{{ route('news.show', $related->slug) }}" class="group">
                                <div class="bg-white border-2 border-black rounded-lg overflow-hidden hover:shadow-2xl transition-all duration-300">
                                    @if($related->image)
                                        <div class="relative h-40 overflow-hidden bg-gray-100">
                                            <img src="{{ Storage::url($related->image) }}" alt="{{ $related->title }}" 
                                                 class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        <h3 class="font-bold mb-2 group-hover:underline line-clamp-2">{{ $related->title }}</h3>
                                        <p class="text-xs text-gray-500">{{ $related->formatted_date }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
