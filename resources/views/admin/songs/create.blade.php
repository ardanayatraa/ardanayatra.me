<x-layouts.admin>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Tambah Lagu Baru</h2>

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Error:</strong> {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="list-disc list-inside mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.songs.store') }}" method="POST" enctype="multipart/form-data" id="songForm">
                        @csrf

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Lagu *</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="artist" class="block text-sm font-medium text-gray-700 mb-2">Nama Artis *</label>
                            <input type="text" name="artist" id="artist" value="{{ old('artist') }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('artist') border-red-500 @enderror">
                            @error('artist')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Serial number will be auto-generated -->

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Audio File (Cloudflare R2) *</label>
                            
                            <div class="flex gap-3">
                                <input type="file" id="audio_file_input" accept="audio/*"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent"
                                       onchange="handleAudioSelect(this)">
                                <button type="button" id="uploadAudioBtn" disabled
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-gray-300 disabled:cursor-not-allowed"
                                        onclick="uploadAudioToR2()">
                                    <span id="uploadAudioText">📤 Upload to R2</span>
                                    <span id="uploadAudioLoading" class="hidden">⏳ Uploading...</span>
                                </button>
                            </div>
                            
                            <input type="hidden" name="audio_file" id="audio_file_path">
                            
                            <p class="text-xs text-gray-500 mt-2">
                                Format: MP3, WAV, OGG, M4A (Max 50MB) • Klik "Upload to R2" setelah pilih file
                            </p>
                            
                            <div id="audioPreview" class="mt-3 hidden">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">📁 File selected:</p>
                                    <div class="bg-white p-3 rounded border border-gray-100">
                                        <p class="text-sm font-semibold text-gray-900" id="audioFileName"></p>
                                        <p class="text-xs text-gray-600" id="audioFileSize"></p>
                                    </div>
                                </div>
                            </div>
                            
                
                            
                            <div id="audioUploaded" class="mt-3 hidden">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-green-800 mb-2">✅ Audio uploaded to R2!</p>
                                    <div class="bg-white p-3 rounded border border-green-100">
                                        <p class="text-sm text-gray-900" id="uploadedFileName"></p>
                                        <p class="text-xs text-gray-600" id="uploadedFilePath"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div id="audioUploadError" class="mt-3 hidden">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-red-800">❌ Upload failed:</p>
                                    <p class="text-xs text-red-700 mt-1" id="uploadErrorMessage"></p>
                                </div>
                            </div>
                            
                            @error('audio_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cover Image (Optional)</label>
                            
                            <div class="flex gap-3">
                                <input type="file" id="cover_image_input" accept="image/*"
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent"
                                       onchange="handleCoverSelect(this)">
                                <button type="button" id="uploadCoverBtn" disabled
                                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition disabled:bg-gray-300 disabled:cursor-not-allowed"
                                        onclick="uploadCoverToR2()">
                                    <span id="uploadCoverText">📤 Upload to R2</span>
                                    <span id="uploadCoverLoading" class="hidden">⏳ Uploading...</span>
                                </button>
                            </div>
                            
                            <input type="hidden" name="cover_image" id="cover_image_path">
                            
                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, PNG (Max 2MB) • Klik "Upload to R2" setelah pilih file
                            </p>
                            
                            <div id="imagePreview" class="mt-3 hidden">
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-gray-700 mb-2">🖼️ Preview:</p>
                                    <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded border border-gray-100">
                                </div>
                            </div>
                            
                            <div id="coverUploaded" class="mt-3 hidden">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-green-800">✅ Cover uploaded to R2!</p>
                                </div>
                            </div>
                            
                            <div id="coverUploadError" class="mt-3 hidden">
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-red-800">❌ Upload cover failed:</p>
                                    <p class="text-xs text-red-700 mt-1" id="uploadCoverErrorMessage"></p>
                                </div>
                            </div>
                            
                            @error('cover_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Note: Lyrics and Markers can be added after creating the song (in edit mode) -->
                        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                💡 <strong>Catatan:</strong> Lirik dan markers bisa ditambahkan setelah lagu dibuat (di halaman edit).
                            </p>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                <strong>💡 Cara Upload:</strong>
                            </p>
                            <ol class="text-sm text-yellow-800 mt-2 ml-4 list-decimal space-y-1">
                                <li>Pilih file audio → Klik "Upload to R2"</li>
                                <li>(Optional) Pilih cover image → Klik "Upload to R2"</li>
                                <li>(Optional) Tambah markers untuk skip ke bagian lagu</li>
                                <li>Setelah upload selesai → Klik "Save Song"</li>
                            </ol>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" id="submitBtn" disabled class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                                💾 Save Song
                            </button>
                            <a href="{{ route('admin.songs.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>

                    <script>
                        let audioUploaded = false;
                        
                        function handleAudioSelect(input) {
                            const preview = document.getElementById('audioPreview');
                            const fileName = document.getElementById('audioFileName');
                            const fileSize = document.getElementById('audioFileSize');
                            const uploadBtn = document.getElementById('uploadAudioBtn');
                            const uploaded = document.getElementById('audioUploaded');
                            const error = document.getElementById('audioUploadError');
                            
                            uploaded.classList.add('hidden');
                            error.classList.add('hidden');
                            audioUploaded = false;
                            checkCanSubmit();
                            
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                const sizeMB = (file.size / 1024 / 1024).toFixed(2);
                                
                                if (file.size > 50 * 1024 * 1024) {
                                    alert('File terlalu besar! Maksimal 50MB');
                                    input.value = '';
                                    preview.classList.add('hidden');
                                    uploadBtn.disabled = true;
                                    return;
                                }
                                
                                fileName.textContent = file.name;
                                fileSize.textContent = `Size: ${sizeMB} MB`;
                                preview.classList.remove('hidden');
                                uploadBtn.disabled = false;
                            }
                        }
                        
                        function handleCoverSelect(input) {
                            const preview = document.getElementById('imagePreview');
                            const img = document.getElementById('previewImg');
                            const uploadBtn = document.getElementById('uploadCoverBtn');
                            const uploaded = document.getElementById('coverUploaded');
                            
                            uploaded.classList.add('hidden');
                            
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                
                                if (file.size > 2 * 1024 * 1024) {
                                    alert('File terlalu besar! Maksimal 2MB');
                                    input.value = '';
                                    preview.classList.add('hidden');
                                    uploadBtn.disabled = true;
                                    return;
                                }
                                
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    img.src = e.target.result;
                                    preview.classList.remove('hidden');
                                }
                                reader.readAsDataURL(file);
                                uploadBtn.disabled = false;
                            }
                        }
                        
                        function uploadAudioToR2() {
                            const input = document.getElementById('audio_file_input');
                            const btn = document.getElementById('uploadAudioBtn');
                            const btnText = document.getElementById('uploadAudioText');
                            const btnLoading = document.getElementById('uploadAudioLoading');
                            const uploaded = document.getElementById('audioUploaded');
                            const error = document.getElementById('audioUploadError');
                            const errorMsg = document.getElementById('uploadErrorMessage');
                            if (!input.files || !input.files[0]) {
                                alert('Pilih file audio terlebih dahulu!');
                                return;
                            }
                            
                            btn.disabled = true;
                            btnText.classList.add('hidden');
                            btnLoading.classList.remove('hidden');
                            error.classList.add('hidden');
                            uploaded.classList.add('hidden');
                            
                            const formData = new FormData();
                            formData.append('audio', input.files[0]);
                            formData.append('_token', '{{ csrf_token() }}');
                            
                            const xhr = new XMLHttpRequest();
                            
                            // Load event (completed)
                            xhr.addEventListener('load', function() {
                                try {
                                    const data = JSON.parse(xhr.responseText);
                                    
                                    if (xhr.status === 200 && data.status === 'success') {
                                        document.getElementById('audio_file_path').value = data.path;
                                        document.getElementById('uploadedFileName').textContent = input.files[0].name;
                                        document.getElementById('uploadedFilePath').textContent = 'Path: ' + data.path;
                                        uploaded.classList.remove('hidden');
                                        audioUploaded = true;
                                        checkCanSubmit();
                                    } else {
                                        throw new Error(data.message || 'Upload gagal. Coba lagi.');
                                    }
                                } catch (err) {
                                    console.error('Upload error:', err);
                                    errorMsg.innerHTML = err.message.replace(/\n/g, '<br>');
                                    error.classList.remove('hidden');
                                    btn.disabled = false;
                                    btnText.classList.remove('hidden');
                                    btnLoading.classList.add('hidden');
                                }
                            });
                            
                            // Error event
                            xhr.addEventListener('error', function() {
                                errorMsg.textContent = 'Network error. Cek koneksi internet.';
                                error.classList.remove('hidden');
                                btn.disabled = false;
                                btnText.classList.remove('hidden');
                                btnLoading.classList.add('hidden');
                            });
                            
                            // Send request
                            xhr.open('POST', '{{ route('test.r2.audio') }}');
                            xhr.send(formData);
                        }
                        
                        async function uploadCoverToR2() {
                            const input = document.getElementById('cover_image_input');
                            const btn = document.getElementById('uploadCoverBtn');
                            const btnText = document.getElementById('uploadCoverText');
                            const btnLoading = document.getElementById('uploadCoverLoading');
                            const uploaded = document.getElementById('coverUploaded');
                            const error = document.getElementById('coverUploadError');
                            const errorMsg = document.getElementById('uploadCoverErrorMessage');
                            
                            if (!input.files || !input.files[0]) {
                                alert('Pilih file cover terlebih dahulu!');
                                return;
                            }
                            
                            btn.disabled = true;
                            btnText.classList.add('hidden');
                            btnLoading.classList.remove('hidden');
                            uploaded.classList.add('hidden');
                            error.classList.add('hidden');
                            
                            const formData = new FormData();
                            formData.append('cover', input.files[0]);
                            formData.append('_token', '{{ csrf_token() }}');
                            
                            try {
                                const response = await fetch('/api/upload-cover', {
                                    method: 'POST',
                                    body: formData
                                });
                                
                                const data = await response.json();
                                
                                if (response.ok && data.status === 'success') {
                                    document.getElementById('cover_image_path').value = data.path;
                                    uploaded.classList.remove('hidden');
                                } else {
                                    let errorText = data.message || 'Upload cover gagal. Coba lagi.';
                                    if (data.help) {
                                        errorText += '\n\n' + data.help;
                                    }
                                    throw new Error(errorText);
                                }
                            } catch (err) {
                                console.error('Cover upload error:', err);
                                
                                // Display error with line breaks
                                errorMsg.innerHTML = err.message.replace(/\n/g, '<br>');
                                error.classList.remove('hidden');
                                
                                // Re-enable button for retry
                                btn.disabled = false;
                            } finally {
                                btnText.classList.remove('hidden');
                                btnLoading.classList.add('hidden');
                            }
                        }
                        
                        function checkCanSubmit() {
                            const submitBtn = document.getElementById('submitBtn');
                            submitBtn.disabled = !audioUploaded;
                        }
                        
                        // Markers functionality
                        let markerCount = 0;
                        
                        // Convert MM:SS to seconds
                        function timeToSeconds(timeStr) {
                            const parts = timeStr.split(':');
                            if (parts.length === 2) {
                                const mins = parseInt(parts[0]) || 0;
                                const secs = parseInt(parts[1]) || 0;
                                return (mins * 60) + secs;
                            }
                            return 0;
                        }
                        
                        function addMarker() {
                            const container = document.getElementById('markersContainer');
                            const markerDiv = document.createElement('div');
                            markerDiv.className = 'flex gap-2 items-start';
                            markerDiv.id = 'marker-' + markerCount;
                            
                            markerDiv.innerHTML = `
                                <input type="text" name="markers[${markerCount}][label]" placeholder="Label (e.g., Intro, Verse 1, Chorus)" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                                <input type="text" id="timeInput${markerCount}" placeholder="MM:SS (e.g., 01:30)" pattern="[0-9]{2}:[0-9]{2}"
                                       class="w-32 px-3 py-2 border border-gray-300 rounded text-sm" maxlength="5"
                                       oninput="formatTimeInput(this)">
                                <input type="hidden" name="markers[${markerCount}][time]" id="timeValue${markerCount}">
                                <button type="button" onclick="removeMarker(${markerCount})" 
                                        class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition">
                                    Hapus
                                </button>
                            `;
                            
                            container.appendChild(markerDiv);
                            
                            // Add event listener to convert time
                            const timeInput = document.getElementById('timeInput' + markerCount);
                            const timeValue = document.getElementById('timeValue' + markerCount);
                            timeInput.addEventListener('blur', function() {
                                timeValue.value = timeToSeconds(this.value);
                            });
                            
                            markerCount++;
                        }
                        
                        function formatTimeInput(input) {
                            let value = input.value.replace(/[^0-9]/g, '');
                            if (value.length >= 2) {
                                value = value.substring(0, 2) + ':' + value.substring(2, 4);
                            }
                            input.value = value;
                        }
                        
                        function removeMarker(id) {
                            const marker = document.getElementById('marker-' + id);
                            if (marker) {
                                marker.remove();
                            }
                        }
                        
                        // Lyrics functionality
                        let lyricCount = 0;
                        
                        function addLyric() {
                            const container = document.getElementById('lyricsContainer');
                            const lyricDiv = document.createElement('div');
                            lyricDiv.className = 'flex flex-col sm:flex-row gap-2 w-full';
                            lyricDiv.id = 'lyric-' + lyricCount;
                            
                            lyricDiv.innerHTML = `
                                <input type="text" id="lyricTimeInput${lyricCount}" placeholder="MM:SS" pattern="[0-9]{2}:[0-9]{2}"
                                       class="w-full sm:w-20 px-3 py-2 border border-gray-300 rounded text-sm font-mono text-center" maxlength="5"
                                       oninput="formatTimeInput(this)" onblur="updateLyricTime(${lyricCount})">
                                <input type="hidden" name="lyrics[${lyricCount}][time]" id="lyricTimeValue${lyricCount}">
                                <input type="text" name="lyrics[${lyricCount}][text]" placeholder="Tulis lirik di sini..." 
                                       class="flex-1 w-full px-3 py-2 border border-gray-300 rounded text-sm">
                                <button type="button" onclick="removeLyric(${lyricCount})" 
                                        class="w-full sm:w-auto px-4 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition flex-shrink-0">
                                    🗑️ Hapus
                                </button>
                            `;
                            
                            container.appendChild(lyricDiv);
                            lyricCount++;
                        }
                        
                        function updateLyricTime(index) {
                            const timeInput = document.getElementById('lyricTimeInput' + index);
                            const timeValue = document.getElementById('lyricTimeValue' + index);
                            if (timeInput && timeValue) {
                                timeValue.value = timeToSeconds(timeInput.value);
                            }
                        }
                        
                        function removeLyric(id) {
                            const lyric = document.getElementById('lyric-' + id);
                            if (lyric) {
                                lyric.remove();
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
