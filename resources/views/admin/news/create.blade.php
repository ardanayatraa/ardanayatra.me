<x-layouts.admin>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Buat Artikel Baru</h2>

                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
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
                            <textarea name="content" id="content" rows="20">{{ old('content') }}</textarea>
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
                                <div class="flex gap-2">
                                    <button type="button" onclick="toggleJsonInput()" class="bg-blue-600 text-white px-4 py-1 rounded text-sm hover:bg-blue-700">
                                        📋 Paste JSON
                                    </button>
                                    <button type="button" onclick="addCitation()" class="bg-green-600 text-white px-4 py-1 rounded text-sm hover:bg-green-700">
                                        + Tambah Referensi
                                    </button>
                                </div>
                            </div>
                            
                            <!-- JSON Input Area -->
                            <div id="json-input-area" class="hidden mb-4 p-4 bg-gray-50 border border-gray-300 rounded">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Paste JSON Citations</label>
                                <textarea id="json-citations" rows="6" placeholder='Paste JSON di sini...' 
                                          class="w-full px-3 py-2 border border-gray-300 rounded text-sm font-mono"></textarea>
                                <div class="flex gap-2 mt-2">
                                    <button type="button" onclick="applyJsonCitations()" class="bg-green-600 text-white px-4 py-2 rounded text-sm hover:bg-green-700">
                                        ✓ Apply
                                    </button>
                                    <button type="button" onclick="showJsonExample()" class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                                        ? Contoh Format
                                    </button>
                                </div>
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
            
            // Form validation
            document.getElementById('newsForm').addEventListener('submit', function(e) {
                const content = editor.getData();
                if (!content || content.trim() === '') {
                    e.preventDefault();
                    alert('Konten artikel tidak boleh kosong!');
                    return false;
                }
            });
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

    function toggleJsonInput() {
        const jsonArea = document.getElementById('json-input-area');
        jsonArea.classList.toggle('hidden');
    }

    function showJsonExample() {
        const example = [
            {
                "author": "Smith, J., & Johnson, M.",
                "title": "Artificial Intelligence in Modern Business",
                "source": "Journal of Technology Management",
                "year": "2024",
                "volume": "15",
                "issue": "3",
                "pages": "245-260",
                "doi": "10.1234/jtm.2024.15.3.245",
                "url": "",
                "type": "journal"
            },
            {
                "author": "Brown, A.",
                "title": "Digital Transformation in Southeast Asia",
                "source": "Tech Publishers",
                "year": "2023",
                "volume": "",
                "issue": "",
                "pages": "",
                "doi": "",
                "url": "https://example.com",
                "type": "book"
            }
        ];
        
        document.getElementById('json-citations').value = JSON.stringify(example, null, 2);
        alert('Contoh format JSON telah diisi!\n\nField yang tersedia:\n- author (required)\n- title (required)\n- source (opsional)\n- year (opsional)\n- volume (opsional)\n- issue (opsional)\n- pages (opsional)\n- doi (opsional)\n- url (opsional)\n- type: journal/book/website/conference (default: journal)');
    }

    function applyJsonCitations() {
        const jsonText = document.getElementById('json-citations').value.trim();
        
        if (!jsonText) {
            alert('Paste JSON citations terlebih dahulu!');
            return;
        }
        
        try {
            const citations = JSON.parse(jsonText);
            
            if (!Array.isArray(citations)) {
                alert('Format JSON harus berupa array!');
                return;
            }
            
            // Clear existing citations
            document.getElementById('citations-container').innerHTML = '';
            citationIndex = 0;
            
            // Add each citation
            citations.forEach((citation, index) => {
                const container = document.getElementById('citations-container');
                const citationHtml = `
                    <div class="citation-item border p-4 rounded mb-4 bg-gray-50">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium text-sm">Referensi #<span class="citation-number">${index + 1}</span></span>
                            <button type="button" onclick="removeCitation(this)" class="text-red-600 text-sm hover:text-red-800">Hapus</button>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <input type="text" name="citations[${index}][author]" placeholder="Penulis *" value="${citation.author || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <select name="citations[${index}][type]" class="w-full px-3 py-1 border rounded text-sm">
                                    <option value="journal" ${citation.type === 'journal' ? 'selected' : ''}>Jurnal</option>
                                    <option value="book" ${citation.type === 'book' ? 'selected' : ''}>Buku</option>
                                    <option value="website" ${citation.type === 'website' ? 'selected' : ''}>Website</option>
                                    <option value="conference" ${citation.type === 'conference' ? 'selected' : ''}>Conference</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <input type="text" name="citations[${index}][title]" placeholder="Judul *" value="${citation.title || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][source]" placeholder="Sumber/Jurnal/Penerbit" value="${citation.source || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][year]" placeholder="Tahun" value="${citation.year || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][volume]" placeholder="Volume" value="${citation.volume || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][issue]" placeholder="Issue/Nomor" value="${citation.issue || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][pages]" placeholder="Halaman" value="${citation.pages || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div>
                                <input type="text" name="citations[${index}][doi]" placeholder="DOI" value="${citation.doi || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                            <div class="col-span-2">
                                <input type="url" name="citations[${index}][url]" placeholder="URL" value="${citation.url || ''}"
                                       class="w-full px-3 py-1 border rounded text-sm">
                            </div>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', citationHtml);
            });
            
            citationIndex = citations.length;
            updateCitationNumbers();
            
            // Hide JSON input area
            document.getElementById('json-input-area').classList.add('hidden');
            document.getElementById('json-citations').value = '';
            
            alert(`Berhasil menambahkan ${citations.length} referensi!`);
            
        } catch (error) {
            alert('Format JSON tidak valid!\n\nError: ' + error.message);
        }
    }
</script>
