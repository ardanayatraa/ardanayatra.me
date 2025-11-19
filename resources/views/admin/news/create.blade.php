<x-layouts.admin>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Buat Artikel Baru</h2>

                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-2">Ringkasan</label>
                            <textarea name="excerpt" id="excerpt" rows="3"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('excerpt') border-red-500 @enderror">{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Konten *</label>
                            <textarea name="content" id="content" rows="20" required>{{ old('content') }}</textarea>
                            @error('content')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Gambar Cover</label>
                            <input type="file" name="image" id="image" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('image') border-red-500 @enderror">
                            @error('image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select name="category_id" id="category_id"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('category_id') border-red-500 @enderror">
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select name="status" id="status" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('status') border-red-500 @enderror">
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                            @error('status')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Citations Section -->
                        <div class="mb-6 border-t pt-6">
                            <div class="flex justify-between items-center mb-4">
                                <label class="block text-sm font-medium text-gray-700">Daftar Pustaka</label>
                                <button type="button" onclick="addCitation()" class="bg-green-600 text-white px-4 py-1 rounded text-sm hover:bg-green-700">
                                    + Tambah Referensi
                                </button>
                            </div>
                            <div id="citations-container"></div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition">
                                Simpan Artikel
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-layouts.admin>


<!-- CKEditor 5 -->
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            toolbar: {
                items: [
                    'heading', '|',
                    'bold', 'italic', 'link', '|',
                    'bulletedList', 'numberedList', '|',
                    'blockQuote', 'insertTable', '|',
                    'undo', 'redo'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            }
        })
        .then(editor => {
            console.log('CKEditor initialized successfully');
            window.editor = editor;
        })
        .catch(error => {
            console.error('Error initializing CKEditor:', error);
        });

    let citationIndex = 0;

    function addCitation() {
        const container = document.getElementById('citations-container');
        const citationHtml = `
            <div class="citation-item border p-4 rounded mb-4 bg-gray-50">
                <div class="flex justify-between mb-2">
                    <span class="font-medium text-sm">Referensi #<span class="citation-number">${citationIndex + 1}</span></span>
                    <button type="button" onclick="removeCitation(this)" class="text-red-600 text-sm hover:text-red-800">Hapus</button>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <input type="text" name="citations[${citationIndex}][author]" placeholder="Penulis *"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <select name="citations[${citationIndex}][type]" class="w-full px-3 py-1 border rounded text-sm">
                            <option value="journal">Jurnal</option>
                            <option value="book">Buku</option>
                            <option value="website">Website</option>
                            <option value="conference">Conference</option>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <input type="text" name="citations[${citationIndex}][title]" placeholder="Judul *"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][source]" placeholder="Sumber/Jurnal/Penerbit"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][year]" placeholder="Tahun"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][volume]" placeholder="Volume"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][issue]" placeholder="Issue/Nomor"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][pages]" placeholder="Halaman"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div>
                        <input type="text" name="citations[${citationIndex}][doi]" placeholder="DOI"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                    <div class="col-span-2">
                        <input type="url" name="citations[${citationIndex}][url]" placeholder="URL"
                               class="w-full px-3 py-1 border rounded text-sm">
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', citationHtml);
        citationIndex++;
        updateCitationNumbers();
    }

    function removeCitation(button) {
        button.closest('.citation-item').remove();
        updateCitationNumbers();
    }

    function updateCitationNumbers() {
        document.querySelectorAll('.citation-number').forEach((el, index) => {
            el.textContent = index + 1;
        });
    }
</script>
