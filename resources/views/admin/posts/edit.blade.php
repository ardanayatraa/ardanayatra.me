<x-layouts.admin>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 py-6">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.posts.index') }}" class="inline-flex items-center text-gray-600 hover:text-black mb-4 transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Posts
            </a>
            <h1 class="text-3xl sm:text-4xl font-bold">Edit Post</h1>
        </div>

        <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Category -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Category *</label>
                <select name="category_id" required class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Title -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Title *</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}" required 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition"
                       placeholder="Enter post title">
                @error('title')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Description *</label>
                <textarea name="description" rows="4" required 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 resize-none transition"
                          placeholder="Enter post description">{{ old('description', $post->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lyrics -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Lyrics <span class="text-gray-500 font-normal">(Optional - for Music)</span></label>
                <textarea name="lyrics" rows="8" 
                          class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 resize-none font-mono text-sm transition"
                          placeholder="Enter lyrics here...">{{ old('lyrics', $post->lyrics) }}</textarea>
                <p class="text-xs text-gray-500 mt-2">Use this field for song lyrics or poetry</p>
            </div>

            <!-- Project URL -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Project URL <span class="text-gray-500 font-normal">(Optional - for Coding)</span></label>
                <input type="url" name="project_url" value="{{ old('project_url', $post->project_url) }}" 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition"
                       placeholder="https://example.com">
                <p class="text-xs text-gray-500 mt-2">Link ke website/project yang dibuat. Ketika cover diklik akan redirect ke URL ini.</p>
            </div>

            <!-- Cover Type -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition" x-data="{ coverType: '{{ old('cover_type', $post->cover_type) }}' }">
                <label class="block text-sm font-semibold mb-4">Cover Type *</label>
                
                <!-- Current Cover Preview -->
                @if($post->cover_type === 'image' && $post->cover_image)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <p class="text-xs font-semibold text-gray-700 mb-2">Current Cover:</p>
                        <img src="{{ $post->cover_image }}" alt="Current cover" class="w-full max-w-md h-48 object-cover rounded-lg">
                    </div>
                @endif
                
                <div class="flex flex-wrap gap-4 mb-6">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="cover_type" value="upload" x-model="coverType" class="w-4 h-4 text-black">
                        <span class="text-sm font-medium group-hover:text-black transition">Upload New Image</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="cover_type" value="image" x-model="coverType" class="w-4 h-4 text-black">
                        <span class="text-sm font-medium group-hover:text-black transition">Image URL</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="cover_type" value="embed" x-model="coverType" class="w-4 h-4 text-black">
                        <span class="text-sm font-medium group-hover:text-black transition">Video Embed</span>
                    </label>
                </div>

                <div x-show="coverType === 'upload'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                    <input type="file" name="cover_upload" accept="image/*"
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-black file:text-white hover:file:bg-gray-800">
                    <p class="text-xs text-gray-500 mt-2">Upload gambar baru (Max: 2MB, Format: JPG, PNG, WebP)</p>
                    @error('cover_upload')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="coverType === 'image'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                    <input type="url" name="cover_image" value="{{ old('cover_image', $post->cover_image) }}" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition"
                           placeholder="https://example.com/image.jpg">
                    <p class="text-xs text-gray-500 mt-2">Direct link to image file</p>
                    @error('cover_image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="coverType === 'embed'" x-transition>
                    <label class="block text-sm font-medium text-gray-700 mb-2">YouTube URL</label>
                    <input type="url" name="embed_url" value="{{ old('embed_url', $post->embed_url) }}" 
                           class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition"
                           placeholder="https://www.youtube.com/watch?v=...">
                    <p class="text-xs text-gray-500 mt-2">Paste YouTube link, it will be converted automatically</p>
                    @error('embed_url')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Music Role (for Music category only) -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition">
                <label class="block text-sm font-semibold mb-3">Peran dalam Karya Musik <span class="text-gray-500 font-normal">(Opsional - khusus musik)</span></label>
                <select name="music_role" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                    <option value="">Tidak ditampilkan</option>
                    <option value="arranger" {{ old('music_role', $post->music_role) == 'arranger' ? 'selected' : '' }}>Arranger (Penata Musik)</option>
                    <option value="songwriter" {{ old('music_role', $post->music_role) == 'songwriter' ? 'selected' : '' }}>Song Writer (Penulis Lagu)</option>
                    <option value="both" {{ old('music_role', $post->music_role) == 'both' ? 'selected' : '' }}>Arranger & Song Writer</option>
                </select>
                <p class="text-xs text-gray-500 mt-2">Badge akan ditampilkan pada post musik</p>
            </div>

            <!-- Publish & For Sale -->
            <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition space-y-4">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }} 
                           class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">
                    <div>
                        <span class="text-sm font-semibold block group-hover:text-black transition">Publish immediately</span>
                        <span class="text-xs text-gray-500">Make this post visible to visitors</span>
                    </div>
                </label>
                
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input type="checkbox" name="is_for_sale" value="1" {{ old('is_for_sale', $post->is_for_sale) ? 'checked' : '' }} 
                           class="w-5 h-5 rounded border-gray-300 text-black focus:ring-black">
                    <div>
                        <span class="text-sm font-semibold block group-hover:text-black transition">Karya ini dijual</span>
                        <span class="text-xs text-gray-500">Tampilkan badge "Dijual" pada post ini</span>
                    </div>
                </label>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button type="submit" 
                        class="flex-1 sm:flex-none px-8 py-4 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold text-sm uppercase tracking-wide">
                    Update Post
                </button>
                <a href="{{ route('admin.posts.index') }}" 
                   class="flex-1 sm:flex-none px-8 py-4 bg-white border-2 border-gray-200 text-center rounded-lg hover:border-black transition font-semibold text-sm uppercase tracking-wide">
                    Cancel
                </a>
            </div>
        </form>

        <!-- Media Links Section -->
        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 mt-8">
            <h2 class="text-xl font-bold mb-6">Media Links</h2>
            
            <form action="{{ route('admin.media-links.store', $post) }}" method="POST" class="mb-6">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    <div>
                        <input type="text" name="platform" placeholder="Platform (e.g., Spotify)" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                    </div>
                    <div>
                        <input type="url" name="url" placeholder="URL" required 
                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                    </div>
                    <div>
                        <button type="submit" class="w-full px-4 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold">
                            Add Link
                        </button>
                    </div>
                </div>
            </form>

            <div class="space-y-3">
                @forelse($post->mediaLinks as $link)
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between p-4 bg-gray-50 border-2 border-gray-200 rounded-lg hover:border-gray-300 transition gap-3">
                        <div class="flex-1 min-w-0">
                            <span class="font-semibold text-sm block">{{ $link->platform }}</span>
                            <a href="{{ $link->url }}" target="_blank" class="text-sm text-gray-600 hover:text-black transition truncate block">
                                {{ Str::limit($link->url, 60) }}
                            </a>
                        </div>
                        <form action="{{ route('admin.media-links.destroy', $link) }}" method="POST" class="flex-shrink-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 text-sm font-semibold text-red-600 hover:text-white hover:bg-red-600 border-2 border-red-600 rounded-lg transition">
                                Delete
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                        <p class="font-medium">No media links yet</p>
                        <p class="text-sm">Add streaming or download links for this post</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
