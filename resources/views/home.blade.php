<x-layouts.app>
    <!-- Welcome Modal -->
    @if(!$hasIntroduced && !auth()->check())
    <div id="welcomeModal" class="fixed inset-0 bg-black/20 backdrop-blur-md flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-lg p-5 sm:p-8 max-w-md w-full">
            <h2 class="text-2xl sm:text-3xl font-bold mb-3 sm:mb-4">Halo! 👋</h2>
            <p class="text-sm sm:text-base text-gray-600 mb-4 sm:mb-6">Sebelum masuk, kenalan dulu yuk! Saya ingin tahu siapa yang berkunjung ke sini 😊</p>
            
            <form id="introForm" onsubmit="submitIntro(event)">
                @csrf
                <div class="mb-4 sm:mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Siapa nama Anda?</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full px-3 py-2 sm:px-4 sm:py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent text-sm sm:text-base"
                           placeholder="Masukkan nama Anda...">
                </div>
                
                <button type="submit" class="w-full bg-black text-white py-2.5 sm:py-3 rounded-lg font-medium hover:bg-gray-800 transition text-sm sm:text-base">
                    Masuk
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section id="heroSection" class="bg-black text-white py-12 md:py-20 border-b border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6 mb-6">
                <div class="flex-1">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold mb-3 md:mb-4" id="heroTitle">Music Portfolio</h2>
                    <p class="text-sm sm:text-base md:text-lg text-gray-300 leading-relaxed" id="heroSubtitle">
                        Mari bersama-sama melestarikan bahasa dan budaya Bali melalui lagu Bali.
                    </p>
                </div>
                <div class="flex gap-2 bg-white/10 rounded-lg p-1 self-start">
                    <button onclick="switchMode('music')" id="musicBtn" class="mode-btn px-4 sm:px-6 py-2 rounded-md text-sm font-medium transition active">
                        Music
                    </button>
                    <button onclick="switchMode('coding')" id="codingBtn" class="mode-btn px-4 sm:px-6 py-2 rounded-md text-sm font-medium transition">
                        Coding
                    </button>
                </div>
            </div>
            
            <!-- Copyright Notice -->
            <div class="border-t border-white/10 pt-3">
                <p class="text-xs text-gray-400 text-center">
                    © Seluruh karya adalah hak cipta <span class="text-white font-semibold">I Made Ardana Yatra</span> sebagai penulis lagu dan arranger musik. Dilarang menggunakan tanpa izin tertulis. 
                    <a href="https://www.hukumonline.com/pusatdata/detail/lt5460681737444/undang-undang-nomor-28-tahun-2014/" 
                       target="_blank"
                       class="text-gray-300 hover:text-white underline transition">
                        (Lihat UU Hak Cipta)
                    </a>
                </p>
            </div>
        </div>
    </section>

    <!-- Message Popup Notification -->
    <div id="messagePopup" class="fixed bottom-4 left-4 right-4 sm:right-auto sm:left-6 sm:max-w-sm bg-white rounded-lg shadow-2xl p-4 transform translate-y-32 opacity-0 transition-all duration-500 z-40 border border-gray-200">
        <div class="flex items-start space-x-3">
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-black rounded-full flex items-center justify-center text-white font-bold">
                    <span id="popupInitial"></span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900" id="popupName"></p>
                <p class="text-xs text-gray-500 mt-1" id="popupMessage"></p>
                <p class="text-xs text-gray-400 mt-1" id="popupTime"></p>
            </div>
            <button onclick="closePopup()" class="flex-shrink-0 text-gray-400 hover:text-gray-600">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Music Mode Content -->
    <div id="musicContent" class="mode-content bg-white">
        <!-- Featured Slider - 3 Latest Posts -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h3 class="text-2xl font-bold mb-6">Latest</h3>
            <div class="relative overflow-hidden rounded-lg">
                <div id="musicSlider" class="flex transition-transform duration-500 ease-in-out">
                    @foreach($featuredPosts->where('category.slug', '!=', 'coding')->take(3) as $post)
                        <div class="min-w-full">
                            <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                <div class="bg-white border-2 border-gray-200 rounded-lg overflow-hidden hover:border-black transition">
                                    @if($post->cover_type === 'image' && $post->cover_image)
                                        <div class="relative h-56 sm:h-72 md:h-80 lg:h-96 overflow-hidden bg-gray-100">
                                            <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                            @if($post->is_for_sale)
                                                <div class="absolute top-4 right-4">
                                                    <span class="badge-dijual inline-block px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-lg">DIJUAL</span>
                                                </div>
                                            @endif
                                        </div>
                                    @elseif($post->cover_type === 'embed' && $post->embed_url)
                                        <div class="relative h-56 sm:h-72 md:h-80 lg:h-96 bg-black">
                                            <iframe src="{{ $post->formatted_embed_url }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                                            @if($post->is_for_sale)
                                                <div class="absolute top-4 right-4">
                                                    <span class="badge-dijual inline-block px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-lg">DIJUAL</span>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="h-56 sm:h-72 md:h-80 lg:h-96 bg-gray-900"></div>
                                    @endif
                                    <div class="p-6">
                                        <div class="flex flex-wrap items-center gap-2 mb-3">
                                            <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium rounded">{{ $post->category->name }}</span>
                                            @if($post->music_role === 'arranger')
                                                <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-medium rounded">Arranger</span>
                                            @elseif($post->music_role === 'songwriter')
                                                <span class="inline-block px-3 py-1 bg-purple-600 text-white text-xs font-medium rounded">Pencipta Lagu</span>
                                            @elseif($post->music_role === 'both')
                                                <span class="inline-block px-3 py-1 bg-indigo-600 text-white text-xs font-medium rounded">Arranger & Pencipta Lagu</span>
                                            @endif
                                        </div>
                                        <h3 class="text-xl sm:text-2xl font-bold mb-2">{{ $post->title }}</h3>
                                        <p class="text-sm sm:text-base text-gray-600">{{ Str::limit($post->description, 150) }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                
                @if($featuredPosts->where('category.slug', '!=', 'coding')->count() > 1)
                <button onclick="prevSlide('music')" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-2 sm:p-3 rounded-full shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="nextSlide('music')" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-2 sm:p-3 rounded-full shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif
            </div>
        </section>

        <!-- All Music Posts Grid -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h3 class="text-2xl font-bold mb-6">All Music</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredPosts->where('category.slug', '!=', 'coding') as $post)
                    <a href="{{ route('posts.show', $post->slug) }}" class="group">
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-black transition-all duration-300">
                            @if($post->cover_type === 'image' && $post->cover_image)
                                <div class="relative h-64 overflow-hidden bg-gray-100">
                                    <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                                    @if($post->is_for_sale)
                                        <div class="absolute top-4 right-4">
                                            <span class="badge-dijual inline-block px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-lg">DIJUAL</span>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-4 left-4 right-4 flex flex-wrap gap-2">
                                        <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium">{{ $post->category->name }}</span>
                                        @if($post->music_role === 'arranger')
                                            <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-medium">Arranger</span>
                                        @elseif($post->music_role === 'songwriter')
                                            <span class="inline-block px-3 py-1 bg-purple-600 text-white text-xs font-medium">Pencipta Lagu</span>
                                        @elseif($post->music_role === 'both')
                                            <span class="inline-block px-3 py-1 bg-indigo-600 text-white text-xs font-medium">Arranger & Pencipta Lagu</span>
                                        @endif
                                    </div>
                                </div>
                            @elseif($post->cover_type === 'embed' && $post->embed_url)
                                <div class="relative h-64 overflow-hidden bg-black">
                                    <iframe src="{{ $post->formatted_embed_url }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                                    @if($post->is_for_sale)
                                        <div class="absolute top-4 right-4">
                                            <span class="badge-dijual inline-block px-3 py-1 bg-green-600 text-white text-xs font-bold rounded shadow-lg">DIJUAL</span>
                                        </div>
                                    @endif
                                    <div class="absolute bottom-4 left-4 right-4 flex flex-wrap gap-2">
                                        <span class="inline-block px-3 py-1 bg-white/90 text-black text-xs font-medium">{{ $post->category->name }}</span>
                                        @if($post->music_role === 'arranger')
                                            <span class="inline-block px-3 py-1 bg-blue-600 text-white text-xs font-medium">Arranger</span>
                                        @elseif($post->music_role === 'songwriter')
                                            <span class="inline-block px-3 py-1 bg-purple-600 text-white text-xs font-medium">Pencipta Lagu</span>
                                        @elseif($post->music_role === 'both')
                                            <span class="inline-block px-3 py-1 bg-indigo-600 text-white text-xs font-medium">Arranger & Pencipta Lagu</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="h-64 bg-gray-900"></div>
                            @endif
                            <div class="p-6">
                                <h3 class="text-xl font-bold mb-2 group-hover:underline">{{ $post->title }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($post->description, 100) }}</p>
                                <div class="mt-4 text-xs text-gray-500">
                                    {{ $post->published_at?->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
    </div>

    <!-- Coding Mode Content -->
    <div id="codingContent" class="mode-content hidden bg-white">
        <!-- Featured Slider - 3 Latest Posts -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h3 class="text-2xl font-bold mb-6">Latest</h3>
            <div class="relative overflow-hidden rounded-lg">
                <div id="codingSlider" class="flex transition-transform duration-500 ease-in-out">
                    @foreach($featuredPosts->where('category.slug', 'coding')->take(3) as $post)
                        <div class="min-w-full">
                            <div class="bg-white border-2 border-gray-200 rounded-lg overflow-hidden hover:border-black transition">
                                @if($post->cover_type === 'image' && $post->cover_image)
                                    {{-- Has cover image --}}
                                    @if($post->project_url)
                                        <a href="{{ $post->project_url }}" target="_blank" class="block h-56 sm:h-72 md:h-80 lg:h-96 overflow-hidden bg-gray-100 relative group/cover">
                                            <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                            <div class="absolute inset-0 bg-black/0 group-hover/cover:bg-black/10 transition flex items-center justify-center">
                                                <span class="opacity-0 group-hover/cover:opacity-100 transition bg-white px-4 py-2 rounded-lg font-semibold text-sm shadow-lg">
                                                    Visit Website →
                                                </span>
                                            </div>
                                        </a>
                                    @else
                                        <div class="h-56 sm:h-72 md:h-80 lg:h-96 overflow-hidden bg-gray-100">
                                            <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                                        </div>
                                    @endif
                                @elseif($post->cover_type === 'embed' && $post->embed_url)
                                    {{-- Has video embed --}}
                                    <div class="h-56 sm:h-72 md:h-80 lg:h-96 bg-black">
                                        <iframe src="{{ $post->formatted_embed_url }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                                    </div>
                                @elseif($post->project_url)
                                    {{-- No cover but has project URL - show iframe --}}
                                    <a href="{{ $post->project_url }}" target="_blank" class="block h-56 sm:h-72 md:h-80 lg:h-96 overflow-hidden bg-white relative group/cover">
                                        <iframe src="{{ $post->project_url }}" class="w-full h-full pointer-events-none scale-50 origin-top-left" style="width: 200%; height: 200%;" frameborder="0"></iframe>
                                        <div class="absolute inset-0 bg-black/0 group-hover/cover:bg-black/10 transition flex items-center justify-center">
                                            <span class="opacity-0 group-hover/cover:opacity-100 transition bg-white px-4 py-2 rounded-lg font-semibold text-sm shadow-lg">
                                                Visit Website →
                                            </span>
                                        </div>
                                    </a>
                                @else
                                    {{-- No cover and no project URL --}}
                                    <div class="h-56 sm:h-72 md:h-80 lg:h-96 bg-gray-900"></div>
                                @endif
                                <a href="{{ route('posts.show', $post->slug) }}" class="block p-4 sm:p-6 hover:bg-gray-50 transition">
                                    <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium rounded mb-3">{{ $post->category->name }}</span>
                                    <h3 class="text-xl sm:text-2xl font-bold mb-2 hover:underline">{{ $post->title }}</h3>
                                    <p class="text-sm sm:text-base text-gray-600">{{ Str::limit($post->description, 150) }}</p>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($featuredPosts->where('category.slug', 'coding')->count() > 1)
                <button onclick="prevSlide('coding')" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-2 sm:p-3 rounded-full shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button onclick="nextSlide('coding')" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-2 sm:p-3 rounded-full shadow-lg z-10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
                @endif
            </div>
        </section>

        <!-- All Coding Posts Grid -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h3 class="text-2xl font-bold mb-6">All Projects</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredPosts->where('category.slug', 'coding') as $post)
                    <div class="group">
                        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-black transition-all duration-300">
                            {{-- Cover Section --}}
                            @if($post->cover_type === 'image' && $post->cover_image)
                                {{-- Has cover image --}}
                                @if($post->project_url)
                                    {{-- Cover clickable to project URL --}}
                                    <a href="{{ $post->project_url }}" target="_blank" class="block relative h-64 overflow-hidden bg-gray-100 group/cover">
                                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover grayscale group-hover/cover:grayscale-0 transition-all duration-300">
                                        
                                        {{-- Overlay with hover effect --}}
                                        <div class="absolute inset-0 bg-black/0 group-hover/cover:bg-black/10 transition flex items-center justify-center">
                                            <span class="opacity-0 group-hover/cover:opacity-100 transition bg-white px-4 py-2 rounded-lg font-semibold text-sm shadow-lg">
                                                Visit Website →
                                            </span>
                                        </div>
                                        
                                        {{-- Category badge --}}
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium shadow-lg">{{ $post->category->name }}</span>
                                        </div>
                                    </a>
                                @else
                                    {{-- Just display cover --}}
                                    <div class="relative h-64 overflow-hidden bg-gray-100">
                                        <img src="{{ $post->cover_image }}" alt="{{ $post->title }}" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-300">
                                        <div class="absolute bottom-4 left-4 right-4">
                                            <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium">{{ $post->category->name }}</span>
                                        </div>
                                    </div>
                                @endif
                            @elseif($post->cover_type === 'embed' && $post->embed_url)
                                {{-- Has video embed --}}
                                <div class="relative h-64 overflow-hidden bg-black">
                                    <iframe src="{{ $post->formatted_embed_url }}" class="w-full h-full pointer-events-none" frameborder="0"></iframe>
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span class="inline-block px-3 py-1 bg-white/90 text-black text-xs font-medium">{{ $post->category->name }}</span>
                                    </div>
                                </div>
                            @elseif($post->project_url)
                                {{-- No cover but has project URL - show iframe of website --}}
                                <a href="{{ $post->project_url }}" target="_blank" class="block relative h-64 overflow-hidden bg-white group/cover">
                                    <iframe src="{{ $post->project_url }}" class="w-full h-full pointer-events-none scale-50 origin-top-left" style="width: 200%; height: 200%;" frameborder="0"></iframe>
                                    
                                    {{-- Overlay with hover effect --}}
                                    <div class="absolute inset-0 bg-black/0 group-hover/cover:bg-black/10 transition flex items-center justify-center">
                                        <span class="opacity-0 group-hover/cover:opacity-100 transition bg-white px-4 py-2 rounded-lg font-semibold text-sm shadow-lg">
                                            Visit Website →
                                        </span>
                                    </div>
                                    
                                    {{-- Category badge --}}
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span class="inline-block px-3 py-1 bg-black text-white text-xs font-medium shadow-lg">{{ $post->category->name }}</span>
                                    </div>
                                </a>
                            @else
                                {{-- No cover and no project URL --}}
                                <div class="relative h-64 overflow-hidden bg-gray-900">
                                    <div class="absolute bottom-4 left-4 right-4">
                                        <span class="inline-block px-3 py-1 bg-white text-black text-xs font-medium">{{ $post->category->name }}</span>
                                    </div>
                                </div>
                            @endif
                            
                            {{-- Post Info --}}
                            <a href="{{ route('posts.show', $post->slug) }}" class="block p-6 hover:bg-gray-50 transition">
                                <h3 class="text-xl font-bold mb-2 hover:underline">{{ $post->title }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2">{{ Str::limit($post->description, 100) }}</p>
                                <div class="mt-4 text-xs text-gray-500">
                                    {{ $post->published_at?->format('M d, Y') }}
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    <!-- About Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 p-4">
        <div id="aboutModalContent" class="bg-white border-4 border-black w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-all duration-300">
            <!-- Header -->
            <div class="bg-black text-white p-6 sm:p-8 flex items-center justify-between border-b-4 border-white">
                <h2 class="text-2xl sm:text-3xl font-bold">Om Swastiastu 🙏</h2>
                <button onclick="closeAboutModal()" class="text-white hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 sm:p-8">
                <!-- Profile Section -->
                <div class="flex flex-col sm:flex-row items-center gap-6 mb-6 pb-6 border-b-2 border-gray-200">
                    <div class="w-24 h-24 bg-black border-4 border-black flex items-center justify-center text-white text-4xl font-bold flex-shrink-0">
                        AY
                    </div>
                    <div class="text-center sm:text-left">
                        <h3 class="text-2xl sm:text-3xl font-bold mb-3">I Made Ardana Yatra</h3>
                        <div class="space-y-2">
                            <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                                <span class="px-3 py-1 bg-black text-white text-sm font-semibold">Web Developer</span>
                                <span class="px-3 py-1 bg-black text-white text-sm font-semibold">Music Arranger</span>
                                <span class="px-3 py-1 bg-black text-white text-sm font-semibold">Pencipta Lagu</span>
                            </div>
                            <p class="text-xs text-gray-600 italic">
                                Pengembang Web | Penata Musik | Penulis Lagu
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-4 text-gray-800 leading-relaxed mb-6">
                    <p class="text-base">
                        Saya adalah seorang <strong>web developer</strong> sekaligus juga suka dalam menciptakan lagu, 
                        khususnya <strong>lagu Bali</strong>.
                    </p>
                    
                    <p class="text-base">
                        Dengan kesempatan kali ini, saya bertujuan untuk <strong><em>memperkenalkan karya-karya yang pernah saya buat</em></strong> 😊
                    </p>

                    <div class="bg-gray-100 p-4 sm:p-5 border-l-4 border-black">
                        <p class="text-sm sm:text-base font-bold text-black">
                            Mari bersama-sama melestarikan bahasa dan budaya Bali melalui lagu Bali
                        </p>
                    </div>
                </div>

                <!-- CTA -->
                <div class="space-y-3 pt-4 border-t-2 border-gray-200">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button onclick="closeAboutModal(); document.getElementById('heroSection').scrollIntoView({ behavior: 'smooth' });" 
                                class="flex-1 px-6 py-3 bg-black text-white font-bold hover:bg-gray-800 transition uppercase text-sm tracking-wide">
                            Lihat Karya Saya
                        </button>
                        <button onclick="closeAboutModal(); openMessageForm();" 
                                class="flex-1 px-6 py-3 border-2 border-black text-black font-bold hover:bg-black hover:text-white transition uppercase text-sm tracking-wide">
                            Kirim Pesan
                        </button>
                    </div>
                    
                    <a href="https://wa.me/6285179799415" 
                       target="_blank"
                       class="flex items-center justify-center gap-2 w-full px-6 py-3 bg-green-600 text-white font-bold hover:bg-green-700 transition uppercase text-sm tracking-wide">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Message Button with Tooltip -->
    <div class="fixed bottom-4 right-4 sm:bottom-6 sm:right-6 z-50">
        <!-- Tooltip -->
        <div id="messageTooltip" class="absolute bottom-full right-0 mb-3 opacity-0 transition-all duration-300 pointer-events-none">
            <div class="bg-black text-white px-4 py-2 rounded-lg shadow-xl whitespace-nowrap text-sm font-medium">
                Ada kritik saran? 💬
                <div class="absolute top-full right-6 -mt-1">
                    <div class="border-8 border-transparent border-t-black"></div>
                </div>
            </div>
        </div>
        
        <!-- Disabled Tooltip (shown when not introduced) -->
        <div id="disabledTooltip" class="absolute bottom-full right-0 mb-3 opacity-0 transition-all duration-300 pointer-events-none">
            <div class="bg-red-600 text-white px-4 py-2 rounded-lg shadow-xl whitespace-nowrap text-sm font-medium">
                Kenalan dulu yuk! 😊
                <div class="absolute top-full right-6 -mt-1">
                    <div class="border-8 border-transparent border-t-red-600"></div>
                </div>
            </div>
        </div>
        
        <!-- Button -->
        <button id="messageButton" onclick="handleMessageButtonClick()" class="bg-black text-white p-3 sm:p-4 rounded-full shadow-2xl hover:bg-gray-800 transition-all hover:scale-110 relative @if(!$hasIntroduced && !auth()->check()) opacity-50 cursor-not-allowed @endif">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
            </svg>
        </button>
    </div>

    <!-- Message Form Popup -->
    <div id="messageFormPopup" class="fixed inset-0 bg-black/20 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
        <div class="bg-white rounded-2xl w-full md:max-w-lg max-h-[90vh] overflow-y-auto">
            <div class="sticky top-0 bg-white border-b p-4 flex items-center justify-between rounded-t-2xl">
                <h3 class="text-xl font-bold">Send Message</h3>
                <button onclick="closeMessageForm()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                    </svg>
                </button>
            </div>
            
            <form action="{{ route('messages.store') }}" method="POST" class="p-6">
                @csrf
                <div class="mb-4">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                    <textarea id="message" name="message" rows="6" required 
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent resize-none"
                              placeholder="Type your message here..."></textarea>
                    <p class="text-xs text-gray-500 mt-2">You can send up to 5 messages per day</p>
                </div>
                
                @if($errors->any())
                    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                        <p class="text-sm text-red-600">{{ $errors->first() }}</p>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-600">{{ session('success') }}</p>
                    </div>
                @endif
                
                <button type="submit" class="w-full bg-black text-white py-3 rounded-lg font-medium hover:bg-gray-800 transition">
                    Send Message
                </button>
            </form>
        </div>
    </div>

    <script>
        // Track if user has introduced themselves
        let hasIntroduced = {{ $hasIntroduced || auth()->check() ? 'true' : 'false' }};

        async function submitIntro(event) {
            event.preventDefault();
            
            const form = event.target;
            const formData = new FormData(form);
            
            try {
                const response = await fetch('{{ route("visitor.store") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        name: formData.get('name')
                    })
                });
                
                if (response.ok) {
                    document.getElementById('welcomeModal').style.display = 'none';
                    hasIntroduced = true;
                    
                    // Enable message button
                    const messageButton = document.getElementById('messageButton');
                    messageButton.classList.remove('opacity-50', 'cursor-not-allowed');
                    messageButton.classList.add('hover:bg-gray-800', 'hover:scale-110');
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }

        // Handle message button click
        function handleMessageButtonClick() {
            if (!hasIntroduced) {
                // Show disabled tooltip
                const disabledTooltip = document.getElementById('disabledTooltip');
                disabledTooltip.style.opacity = '1';
                disabledTooltip.style.transform = 'translateY(0)';
                
                // Shake the button
                const button = document.getElementById('messageButton');
                button.classList.add('animate-shake');
                
                // Hide tooltip and stop shake after 2 seconds
                setTimeout(() => {
                    button.classList.remove('animate-shake');
                    disabledTooltip.style.opacity = '0';
                    disabledTooltip.style.transform = 'translateY(10px)';
                }, 2000);
                
                return;
            }
            
            // If introduced, open message form
            openMessageForm();
        }

        function switchMode(mode) {
            const musicBtn = document.getElementById('musicBtn');
            const codingBtn = document.getElementById('codingBtn');
            const musicContent = document.getElementById('musicContent');
            const codingContent = document.getElementById('codingContent');
            const heroTitle = document.getElementById('heroTitle');
            const heroSubtitle = document.getElementById('heroSubtitle');
            const heroSection = document.getElementById('heroSection');
            
            if (mode === 'music') {
                musicBtn.classList.add('active');
                codingBtn.classList.remove('active');
                musicContent.classList.remove('hidden');
                codingContent.classList.add('hidden');
                heroTitle.textContent = 'Music Portfolio';
                heroSubtitle.textContent = 'Mari bersama-sama melestarikan bahasa dan budaya Bali melalui lagu Bali.';
                heroSection.className = 'bg-black text-white py-12 md:py-20 border-b border-gray-800';
            } else {
                codingBtn.classList.add('active');
                musicBtn.classList.remove('active');
                codingContent.classList.remove('hidden');
                musicContent.classList.add('hidden');
                heroTitle.textContent = 'Coding Projects';
                heroSubtitle.textContent = 'Yang butuh jasa pembuatan website bisa langsung hubungi kontak tertera (business only).';
                heroSection.className = 'bg-stailo-green text-white py-12 md:py-20 border-b border-green-900';
            }
            
            // Save preference
            localStorage.setItem('preferredMode', mode);
        }
        
        // Load saved preference
        window.addEventListener('DOMContentLoaded', () => {
            const savedMode = localStorage.getItem('preferredMode') || 'music';
            switchMode(savedMode);
        });

        // About Modal functions
        function openAboutModal() {
            const modal = document.getElementById('aboutModal');
            const content = document.getElementById('aboutModalContent');
            
            modal.classList.remove('opacity-0', 'pointer-events-none');
            document.body.style.overflow = 'hidden';
            
            // Trigger animation after a small delay
            setTimeout(() => {
                content.classList.remove('scale-95');
                content.classList.add('scale-100');
            }, 10);
        }

        function closeAboutModal() {
            const modal = document.getElementById('aboutModal');
            const content = document.getElementById('aboutModalContent');
            
            content.classList.remove('scale-100');
            content.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
                document.body.style.overflow = 'auto';
            }, 300);
        }

        // Message Popup Notifications
        const messages = @json($messages);
        let currentMessageIndex = 0;
        let popupTimeout;

        function showPopup(message) {
            const popup = document.getElementById('messagePopup');
            const name = message.visitor ? message.visitor.name : 'Anonymous';
            const initial = name.charAt(0).toUpperCase();
            
            document.getElementById('popupInitial').textContent = initial;
            document.getElementById('popupName').textContent = name;
            document.getElementById('popupMessage').textContent = '"' + message.message + '"';
            document.getElementById('popupTime').textContent = message.created_at_human;
            
            // Show popup
            popup.classList.remove('translate-y-32', 'opacity-0');
            popup.classList.add('translate-y-0', 'opacity-100');
            
            // Auto hide after 5 seconds
            clearTimeout(popupTimeout);
            popupTimeout = setTimeout(() => {
                closePopup();
            }, 5000);
        }

        function closePopup() {
            const popup = document.getElementById('messagePopup');
            popup.classList.add('translate-y-32', 'opacity-0');
            popup.classList.remove('translate-y-0', 'opacity-100');
        }

        function showNextMessage() {
            if (messages.length > 0) {
                showPopup(messages[currentMessageIndex]);
                currentMessageIndex = (currentMessageIndex + 1) % messages.length;
            }
        }

        // Show first popup after 3 seconds
        @if($messages->count() > 0)
        setTimeout(() => {
            showNextMessage();
            
            // Show next popup every 8 seconds
            setInterval(() => {
                showNextMessage();
            }, 8000);
        }, 3000);
        @endif

        // Message Form Popup
        function openMessageForm() {
            document.getElementById('messageFormPopup').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMessageForm() {
            document.getElementById('messageFormPopup').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Auto open message form if there are errors or success message
        @if($errors->any() || session('success'))
        window.addEventListener('DOMContentLoaded', () => {
            openMessageForm();
        });
        @endif

        // Slider functionality
        let currentMusicSlide = 0;
        let currentCodingSlide = 0;
        const musicSlidesCount = {{ $featuredPosts->where('category.slug', '!=', 'coding')->take(3)->count() }};
        const codingSlidesCount = {{ $featuredPosts->where('category.slug', 'coding')->take(3)->count() }};

        function showSlide(mode, index) {
            const slider = document.getElementById(mode + 'Slider');
            if (slider) {
                slider.style.transform = `translateX(-${index * 100}%)`;
            }
        }

        function nextSlide(mode) {
            if (mode === 'music') {
                currentMusicSlide = (currentMusicSlide + 1) % musicSlidesCount;
                showSlide('music', currentMusicSlide);
            } else {
                currentCodingSlide = (currentCodingSlide + 1) % codingSlidesCount;
                showSlide('coding', currentCodingSlide);
            }
        }

        function prevSlide(mode) {
            if (mode === 'music') {
                currentMusicSlide = (currentMusicSlide - 1 + musicSlidesCount) % musicSlidesCount;
                showSlide('music', currentMusicSlide);
            } else {
                currentCodingSlide = (currentCodingSlide - 1 + codingSlidesCount) % codingSlidesCount;
                showSlide('coding', currentCodingSlide);
            }
        }

        // Auto rotate sliders every 5 seconds
        setInterval(() => {
            if (musicSlidesCount > 1) nextSlide('music');
        }, 5000);

        setInterval(() => {
            if (codingSlidesCount > 1) nextSlide('coding');
        }, 5000);

        // Shake message button every 10 seconds with tooltip
        function shakeMessageButton() {
            // Only shake if user has introduced themselves
            if (!hasIntroduced) return;
            
            const button = document.getElementById('messageButton');
            const tooltip = document.getElementById('messageTooltip');
            
            // Show tooltip
            tooltip.style.opacity = '1';
            tooltip.style.transform = 'translateY(0)';
            
            // Shake button
            button.classList.add('animate-shake');
            
            // Hide tooltip and stop shake after 3 seconds
            setTimeout(() => {
                button.classList.remove('animate-shake');
                tooltip.style.opacity = '0';
                tooltip.style.transform = 'translateY(10px)';
            }, 3000);
        }

        // Start shaking after 5 seconds, then every 10 seconds
        setTimeout(() => {
            shakeMessageButton();
            setInterval(shakeMessageButton, 10000);
        }, 5000);

        // Shake DIJUAL badges every 10 seconds
        function shakeDijualBadges() {
            const badges = document.querySelectorAll('.badge-dijual');
            badges.forEach(badge => {
                badge.classList.add('animate-shake');
                setTimeout(() => {
                    badge.classList.remove('animate-shake');
                }, 1000);
            });
        }

        // Start shaking badges after 3 seconds, then every 10 seconds
        setTimeout(() => {
            shakeDijualBadges();
            setInterval(shakeDijualBadges, 10000);
        }, 3000);
    </script>

    <style>
        .bg-stailo-green {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }
        .mode-btn {
            color: rgba(255, 255, 255, 0.6);
        }
        .mode-btn.active {
            background: white;
            color: #1f2937;
        }
        
        /* Shake animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0) rotate(0deg); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-10px) rotate(-5deg); }
            20%, 40%, 60%, 80% { transform: translateX(10px) rotate(5deg); }
        }
        
        .animate-shake {
            animation: shake 0.8s cubic-bezier(.36,.07,.19,.97) both;
        }
    </style>
</x-layouts.app>
