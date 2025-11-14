<x-layouts.admin>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl sm:text-4xl font-bold mb-2">Categories</h1>
            <p class="text-gray-600">Manage music and coding categories</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-2 border-green-200 rounded-lg">
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        @endif

        <!-- Error Message -->
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-2 border-red-200 rounded-lg">
                <p class="text-red-800 font-medium">{{ $errors->first() }}</p>
            </div>
        @endif

        <!-- Add New Category Form -->
        <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 mb-8 hover:border-gray-300 transition">
            <h2 class="text-xl font-bold mb-4">Add New Category</h2>
            <form action="{{ route('admin.categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="text" name="name" placeholder="Category name" required 
                       class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition"
                       value="{{ old('name') }}">
                <button type="submit" 
                        class="px-8 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold text-sm uppercase tracking-wide">
                    Add Category
                </button>
            </form>
        </div>

        <!-- Categories List -->
        <div class="space-y-4">
            @forelse($categories as $category)
                <div class="bg-white border-2 border-gray-200 rounded-lg p-4 sm:p-6 hover:border-gray-300 transition" 
                     x-data="{ editing: false, name: '{{ $category->name }}' }">
                    
                    <!-- View Mode -->
                    <div x-show="!editing" class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex-1">
                            <h3 class="text-xl font-bold mb-1">{{ $category->name }}</h3>
                            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-600">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    {{ $category->slug }}
                                </span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $category->posts_count }} posts
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex gap-2">
                            <button @click="editing = true" 
                                    class="px-4 py-2 border-2 border-gray-200 rounded-lg hover:border-black transition font-semibold text-sm">
                                Edit
                            </button>
                            
                            @if($category->posts_count == 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-4 py-2 border-2 border-red-600 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition font-semibold text-sm">
                                        Delete
                                    </button>
                                </form>
                            @else
                                <button disabled 
                                        class="px-4 py-2 border-2 border-gray-200 text-gray-400 rounded-lg cursor-not-allowed font-semibold text-sm"
                                        title="Cannot delete category with posts">
                                    Delete
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <form x-show="editing" 
                          action="{{ route('admin.categories.update', $category) }}" 
                          method="POST" 
                          class="flex flex-col sm:flex-row gap-3">
                        @csrf
                        @method('PUT')
                        <input type="text" 
                               name="name" 
                               x-model="name"
                               required 
                               class="flex-1 px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-black focus:ring-0 transition">
                        <div class="flex gap-2">
                            <button type="submit" 
                                    class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition font-semibold text-sm">
                                Save
                            </button>
                            <button type="button" 
                                    @click="editing = false; name = '{{ $category->name }}'" 
                                    class="px-6 py-3 border-2 border-gray-200 rounded-lg hover:border-black transition font-semibold text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            @empty
                <div class="bg-white border-2 border-gray-200 rounded-lg p-12 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                    <h3 class="text-xl font-bold mb-2">No categories yet</h3>
                    <p class="text-gray-600">Create your first category to organize your posts</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.admin>
