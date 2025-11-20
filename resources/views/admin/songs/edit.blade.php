<x-layouts.admin>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-6">Edit Lagu</h2>

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

                    <form action="{{ route('admin.songs.update', $song) }}" method="POST" enctype="multipart/form-data" id="songForm">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Lagu *</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $song->title) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('title') border-red-500 @enderror">
                            @error('title')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="artist" class="block text-sm font-medium text-gray-700 mb-2">Nama Artis *</label>
                            <input type="text" name="artist" id="artist" value="{{ old('artist', $song->artist) }}" required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('artist') border-red-500 @enderror">
                            @error('artist')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="serial_number" class="block text-sm font-medium text-gray-700 mb-2">Nomor Seri</label>
                            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number', $song->serial_number) }}" placeholder="Contoh: IMAY-001"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('serial_number') border-red-500 @enderror">
                            <p class="text-xs text-gray-500 mt-1">Nomor seri unik untuk identifikasi karya</p>
                            @error('serial_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($song->audio_file)
                        <!-- Sticky Audio Player -->
                        <div id="audioPlayerContainer" class="mb-6">
                            <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                                <p class="text-sm font-medium text-green-800 mb-2">🎵 Audio Player</p>
                                <audio id="audioPlayer" controls class="w-full">
                                    <source src="{{ $song->audio_url }}" type="audio/mpeg">
                                </audio>
                                <p class="text-xs text-gray-600 mt-2">💡 Player akan tetap di atas saat scroll</p>
                            </div>
                        </div>
                        
                        <!-- Placeholder for sticky player -->
                        <div id="audioPlayerPlaceholder" class="hidden mb-6"></div>
                        
                        <!-- Fixed Audio Player (clone) -->
                        <div id="audioPlayerFixed" class="hidden fixed top-0 left-0 right-0 z-50 bg-white shadow-lg border-b-2 border-green-500">
                            <div class="max-w-4xl mx-auto px-6 py-4">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-green-800 mb-2">🎵 Audio Player (Sticky)</p>
                                    <audio id="audioPlayerClone" controls class="w-full">
                                        <source src="{{ $song->audio_url }}" type="audio/mpeg">
                                    </audio>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Audio File Baru (Optional)</label>
                            <input type="file" name="audio_file" id="audio_file" accept="audio/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('audio_file') border-red-500 @enderror"
                                   onchange="previewAudio(this)">
                            <p class="text-xs text-gray-500 mt-2">
                                Format: MP3, WAV, OGG, M4A (Max 50MB) • Akan replace file lama
                            </p>
                            <div id="audioPreview" class="mt-3 hidden">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-blue-800 mb-2">📁 File baru siap diupload ke R2:</p>
                                    <div class="bg-white p-3 rounded border border-blue-100">
                                        <p class="text-sm font-semibold text-gray-900" id="audioFileName"></p>
                                        <p class="text-xs text-gray-600" id="audioFileSize"></p>
                                    </div>
                                    <p class="text-xs text-blue-600 mt-2">
                                        ⚠️ File belum diupload. Klik "Update Lagu" untuk upload & replace file lama di R2.
                                    </p>
                                </div>
                            </div>
                            @error('audio_file')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        @if($song->cover_image)
                        <div class="mb-6">
                            <p class="text-sm font-medium text-gray-700 mb-2">Cover Image Saat Ini:</p>
                            <img src="{{ $song->cover_url }}" alt="Cover" class="w-32 h-32 object-cover rounded">
                        </div>
                        @endif

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Cover Image Baru (Optional)</label>
                            <input type="file" name="cover_image" id="cover_image" accept="image/*"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent @error('cover_image') border-red-500 @enderror"
                                   onchange="previewImage(this)">
                            <p class="text-xs text-gray-500 mt-2">
                                Format: JPG, PNG (Max 2MB)
                            </p>
                            <div id="imagePreview" class="mt-3 hidden">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                    <p class="text-sm font-medium text-blue-800 mb-2">🖼️ Preview cover baru:</p>
                                    <img id="previewImg" src="" alt="Preview" class="w-32 h-32 object-cover rounded border border-blue-100">
                                    <p class="text-xs text-blue-600 mt-2">
                                        ⚠️ Cover belum diupload. Klik "Update Lagu" untuk upload & replace cover lama di R2.
                                    </p>
                                </div>
                            </div>
                            @error('cover_image')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <!-- Song Markers (Optional) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Song Markers (Optional)</label>
                            <p class="text-xs text-gray-500 mb-3">Tambahkan marker untuk bagian lagu (Intro, Verse, Chorus, dll) agar pendengar bisa skip ke bagian tertentu</p>
                            
                            <div id="markersContainer" class="space-y-2 mb-3">
                                @if($song->markers && count($song->markers) > 0)
                                    @foreach($song->markers as $index => $marker)
                                        <div class="flex gap-2 items-start" id="marker-{{ $index }}">
                                            <input type="text" name="markers[{{ $index }}][label]" value="{{ $marker['label'] }}" placeholder="Label (e.g., Intro, Verse 1, Chorus)" 
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                                            <input type="text" id="timeInput{{ $index }}" value="{{ gmdate('i:s', $marker['time']) }}" placeholder="MM:SS (e.g., 01:30)" pattern="[0-9]{2}:[0-9]{2}"
                                                   class="w-32 px-3 py-2 border border-gray-300 rounded text-sm" maxlength="5"
                                                   oninput="formatTimeInput(this)" onblur="updateTimeValue({{ $index }})">
                                            <input type="hidden" name="markers[{{ $index }}][time]" id="timeValue{{ $index }}" value="{{ $marker['time'] }}">
                                            <button type="button" onclick="removeMarker({{ $index }})" 
                                                    class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <button type="button" onclick="addMarker()" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded transition">
                                + Tambah Marker
                            </button>
                            
                            <p class="text-xs text-gray-500 mt-2">💡 Format waktu: MM:SS (contoh: 00:15 untuk 15 detik, 01:30 untuk 1 menit 30 detik)</p>
                        </div>

                        <!-- Synchronized Lyrics (Optional) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Synchronized Lyrics (Optional)</label>
                            <p class="text-xs text-gray-500 mb-3">Tambahkan lirik yang sinkron dengan lagu (seperti karaoke)</p>
                            
                            <div id="lyricsContainer" class="space-y-2 mb-3">
                                @if($song->lyrics && count($song->lyrics) > 0)
                                    @foreach($song->lyrics as $index => $lyric)
                                        <div class="flex gap-2 items-start" id="lyric-{{ $index }}">
                                            <input type="text" name="lyrics[{{ $index }}][text]" value="{{ $lyric['text'] }}" placeholder="Baris lirik" 
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                                            <input type="text" id="lyricTimeInput{{ $index }}" value="{{ gmdate('i:s', $lyric['time']) }}" placeholder="MM:SS" pattern="[0-9]{2}:[0-9]{2}"
                                                   class="w-24 px-3 py-2 border border-gray-300 rounded text-sm" maxlength="5"
                                                   oninput="formatTimeInput(this)" onblur="updateLyricTime({{ $index }})">
                                            <input type="hidden" name="lyrics[{{ $index }}][time]" id="lyricTimeValue{{ $index }}" value="{{ $lyric['time'] }}">
                                            <button type="button" onclick="removeLyric({{ $index }})" 
                                                    class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition">
                                                Hapus
                                            </button>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            
                            <button type="button" onclick="addLyric()" class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded transition">
                                + Tambah Baris Lirik
                            </button>
                            
                            <p class="text-xs text-gray-500 mt-2">💡 Tambahkan lirik per baris dengan waktu kemunculannya (format MM:SS)</p>
                        </div>

                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                            <p class="text-sm text-yellow-800">
                                <strong>💡 Info:</strong> File baru akan diupload ke Cloudflare R2 dan menggantikan file lama saat Anda klik "Update Lagu".
                            </p>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" id="submitBtn" class="bg-black text-white px-6 py-2 rounded-lg hover:bg-gray-800 transition disabled:bg-gray-400 disabled:cursor-not-allowed">
                                <span id="submitText">💾 Update & Upload ke R2</span>
                                <span id="loadingText" class="hidden">
                                    <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    ⏳ Uploading ke R2...
                                </span>
                            </button>
                            <a href="{{ route('admin.songs.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
                                Batal
                            </a>
                        </div>
                    </form>

                    <script>
                        function previewAudio(input) {
                            const preview = document.getElementById('audioPreview');
                            const fileName = document.getElementById('audioFileName');
                            const fileSize = document.getElementById('audioFileSize');
                            
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                const sizeMB = (file.size / 1024 / 1024).toFixed(2);
                                
                                fileName.textContent = file.name;
                                fileSize.textContent = `Ukuran: ${sizeMB} MB`;
                                preview.classList.remove('hidden');
                                
                                if (file.size > 50 * 1024 * 1024) {
                                    alert('File terlalu besar! Maksimal 50MB');
                                    input.value = '';
                                    preview.classList.add('hidden');
                                }
                            }
                        }

                        function previewImage(input) {
                            const preview = document.getElementById('imagePreview');
                            const img = document.getElementById('previewImg');
                            
                            if (input.files && input.files[0]) {
                                const file = input.files[0];
                                const reader = new FileReader();
                                
                                reader.onload = function(e) {
                                    img.src = e.target.result;
                                    preview.classList.remove('hidden');
                                }
                                
                                reader.readAsDataURL(file);
                                
                                if (file.size > 2 * 1024 * 1024) {
                                    alert('File terlalu besar! Maksimal 2MB');
                                    input.value = '';
                                    preview.classList.add('hidden');
                                }
                            }
                        }

                        document.getElementById('songForm').addEventListener('submit', function() {
                            const submitBtn = document.getElementById('submitBtn');
                            const submitText = document.getElementById('submitText');
                            const loadingText = document.getElementById('loadingText');
                            
                            submitBtn.disabled = true;
                            submitText.classList.add('hidden');
                            loadingText.classList.remove('hidden');
                        });
                        
                        // Markers functionality
                        let markerCount = {{ $song->markers ? count($song->markers) : 0 }};
                        
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
                        
                        function updateTimeValue(index) {
                            const timeInput = document.getElementById('timeInput' + index);
                            const timeValue = document.getElementById('timeValue' + index);
                            if (timeInput && timeValue) {
                                timeValue.value = timeToSeconds(timeInput.value);
                            }
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
                                       oninput="formatTimeInput(this)" onblur="updateTimeValue(${markerCount})">
                                <input type="hidden" name="markers[${markerCount}][time]" id="timeValue${markerCount}">
                                <button type="button" onclick="removeMarker(${markerCount})" 
                                        class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition">
                                    Hapus
                                </button>
                            `;
                            
                            container.appendChild(markerDiv);
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
                        let lyricCount = {{ $song->lyrics ? count($song->lyrics) : 0 }};
                        
                        function addLyric() {
                            const container = document.getElementById('lyricsContainer');
                            const lyricDiv = document.createElement('div');
                            lyricDiv.className = 'flex gap-2 items-start';
                            lyricDiv.id = 'lyric-' + lyricCount;
                            
                            lyricDiv.innerHTML = `
                                <input type="text" name="lyrics[${lyricCount}][text]" placeholder="Baris lirik (contoh: Ku ingin kau tahu...)" 
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm">
                                <input type="text" id="lyricTimeInput${lyricCount}" placeholder="MM:SS" pattern="[0-9]{2}:[0-9]{2}"
                                       class="w-24 px-3 py-2 border border-gray-300 rounded text-sm" maxlength="5"
                                       oninput="formatTimeInput(this)" onblur="updateLyricTime(${lyricCount})">
                                <input type="hidden" name="lyrics[${lyricCount}][time]" id="lyricTimeValue${lyricCount}">
                                <button type="button" onclick="removeLyric(${lyricCount})" 
                                        class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded text-sm transition">
                                    Hapus
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
                    
                    @if($song->audio_file)
                    <script>
                        // Sticky Audio Player
                        window.addEventListener('scroll', function() {
                            const container = document.getElementById('audioPlayerContainer');
                            const fixed = document.getElementById('audioPlayerFixed');
                            const placeholder = document.getElementById('audioPlayerPlaceholder');
                            const player = document.getElementById('audioPlayer');
                            const playerClone = document.getElementById('audioPlayerClone');
                            
                            if (!container || !fixed) return;
                            
                            const containerRect = container.getBoundingClientRect();
                            
                            // If original player scrolled out of view
                            if (containerRect.bottom < 0) {
                                fixed.classList.remove('hidden');
                                placeholder.classList.remove('hidden');
                                
                                // Sync playback state
                                if (!player.paused && playerClone.paused) {
                                    playerClone.currentTime = player.currentTime;
                                    playerClone.play();
                                }
                            } else {
                                fixed.classList.add('hidden');
                                placeholder.classList.add('hidden');
                                
                                // Sync back to original
                                if (!playerClone.paused && player.paused) {
                                    player.currentTime = playerClone.currentTime;
                                    player.play();
                                }
                            }
                        });
                        
                        // Sync between two players
                        const player = document.getElementById('audioPlayer');
                        const playerClone = document.getElementById('audioPlayerClone');
                        
                        if (player && playerClone) {
                            player.addEventListener('play', () => {
                                if (playerClone.paused) {
                                    playerClone.currentTime = player.currentTime;
                                    playerClone.play();
                                }
                            });
                            
                            player.addEventListener('pause', () => {
                                playerClone.pause();
                            });
                            
                            playerClone.addEventListener('play', () => {
                                if (player.paused) {
                                    player.currentTime = playerClone.currentTime;
                                    player.play();
                                }
                            });
                            
                            playerClone.addEventListener('pause', () => {
                                player.pause();
                            });
                        }
                    </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
