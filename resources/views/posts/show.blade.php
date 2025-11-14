<x-layouts.app>
    @php
        $isMusic = $post->category->slug !== 'coding';
        $themeBg = $isMusic ? 'bg-black' : 'bg-maroon';
        $themeHover = $isMusic ? 'hover:border-black hover:bg-gray-50' : 'hover:border-maroon hover:bg-red-50';
    @endphp

    <!-- Hero Section with Cover -->
    <section class="{{ $themeBg }} text-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="inline-flex items-center text-white/80 hover:text-white mb-8 text-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Home
            </a>
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Title & Info -->
                <div>
                    <div class="inline-block px-3 py-1 bg-white/20 rounded text-xs font-medium mb-6">
                        {{ $post->category->name }}
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold mb-6 leading-tight">{{ $post->title }}</h1>
                    <div class="text-white/70 text-sm">
                        {{ $post->published_at->format('F d, Y') }}
                    </div>
                </div>
                
                <!-- Right: Cover/Iframe -->
                <div class="max-w-md">
                    @if($post->cover_type === 'image' && $post->cover_image)
                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full rounded-lg shadow-xl">
                    @elseif($post->cover_type === 'embed' && $post->embed_url)
                        <div class="aspect-video">
                            <iframe src="{{ $post->formatted_embed_url }}" class="w-full h-full rounded-lg shadow-xl" allowfullscreen></iframe>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Content -->
    <article class="bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <!-- Description -->
            <div class="mb-12">
                <p class="text-gray-700 text-lg leading-relaxed whitespace-pre-line">{{ $post->description }}</p>
            </div>

            <!-- Lyrics -->
            @if($post->lyrics)
                <div class="bg-gray-50 rounded-lg p-8 mb-12">
                    <h2 class="text-2xl font-bold mb-6">Lyrics</h2>
                    <div class="text-gray-700 whitespace-pre-line leading-loose">{{ $post->lyrics }}</div>
                </div>
            @endif

            <!-- Media Links -->
            @if($post->mediaLinks->count() > 0)
                <div class="border-t pt-12">
                    <h2 class="text-2xl font-bold mb-6">Listen On</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($post->mediaLinks as $link)
                            <a href="{{ $link->url }}" target="_blank" class="flex items-center justify-between p-4 border-2 border-gray-200 rounded-lg {{ $themeHover }} transition">
                                <span class="font-medium">{{ $link->platform }}</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>

    <style>
        .bg-maroon {
            background-color: #800000;
        }
    </style>
</x-layouts.app>
