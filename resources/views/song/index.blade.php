<x-layouts.app>
    <style>
        /* Smooth lyric transition animations */
        [id^="currentLyric"] {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }
        
        /* Hide audio download button */
        audio::-webkit-media-controls-download-button {
            display: none !important;
        }
        audio::-webkit-media-controls-enclosure {
            overflow: hidden;
        }
        audio::-internal-media-controls-download-button {
            display: none !important;
        }
    </style>
    
    <div class="min-h-screen bg-white">
        <!-- Simple Header -->
        <div class="bg-black text-white py-12 px-6">
            <div class="container mx-auto max-w-6xl">
                <h1 class="text-4xl md:text-5xl font-bold mb-3">My Original Songs</h1>
                <p class="text-gray-300 mb-3">Portofolio lagu ciptaan sendiri yang belum pernah didaftarkan ke agregator manapun</p>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400 mb-3">
                    <span class="font-semibold text-white">I Made Ardana Yatra</span>
                    <span>•</span>
                    <span>{{ $songs->total() }} lagu</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ number_format($totalViews) }}
                    </span>
                </div>
                <div class="inline-flex items-center gap-2 bg-white/10 px-4 py-2 rounded-full text-sm">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                    </svg>
                    <span>Berminat? Hubungi via TikTok: <a href="https://www.tiktok.com/@ardanayatraa" target="_blank" class="font-semibold text-white hover:underline">@ardanayatraa</a></span>
                </div>
            </div>
        </div>
            
        
        <!-- Main Content -->
        <div class="container mx-auto max-w-6xl px-6 py-8">
            <!-- Copyright Notice -->
            <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-yellow-800 mb-1">⚠️ Pemberitahuan Hak Cipta</p>
                        <p class="text-xs text-yellow-700">
                            Seluruh lagu adalah karya original dan dilindungi hak cipta. 
                            Dilarang menggunakan, mendistribusikan, atau mengklaim sebagai karya sendiri tanpa izin dari pencipta.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Songs List -->
            @if($songs->count() > 0)
                <div class="space-y-2 mb-8">
                    @foreach($songs as $index => $song)
                        <div class="group bg-white border border-gray-200 rounded-lg hover:shadow-md transition-all duration-200" id="song{{ $index }}">
                            <div class="p-4">
                                <!-- Synchronized Lyrics Display (Always visible at top) -->
                                @if($song->lyrics && count($song->lyrics) > 0)
                                <div id="lyricsDisplay{{ $index }}" class="mb-3">
                                    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-4">
                                        <p id="currentLyric{{ $index }}" class="text-base font-semibold text-gray-800 text-center min-h-[3rem] flex items-center justify-center transition-all duration-500 ease-in-out transform">
                                            ...
                                        </p>
                                    </div>
                                </div>
                                @endif
                                
                                <!-- Song Markers (Always visible) -->
                                @if($song->markers && count($song->markers) > 0)
                                <div id="markersButtons{{ $index }}" class="mb-3">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="text-xs text-gray-500 italic">💡 Tekan untuk loncat ke bagian lagu:</span>
                                    </div>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($song->markers as $marker)
                                        <button onclick="jumpToMarker{{ $index }}({{ $marker['time'] }})" 
                                                class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-full transition active:scale-95">
                                            {{ $marker['label'] }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                                
                                <div class="flex items-center gap-4 mb-3">
                                    <!-- Play/Pause Button -->
                                    <button onclick="togglePlay{{ $index }}()" class="flex-shrink-0 w-12 h-12 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center transition-all hover:scale-105">
                                        <svg id="playIcon{{ $index }}" class="w-5 h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                        </svg>
                                        <svg id="pauseIcon{{ $index }}" class="hidden w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Restart Button (Hidden until playing) -->
                                    <button id="restartBtn{{ $index }}" onclick="restartAudio{{ $index }}()" class="hidden flex-shrink-0 w-10 h-10 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center transition-all hover:scale-105 active:scale-95" title="Ulang dari awal">
                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                                        </svg>
                                    </button>
                                    
                                    <!-- Song Info -->
                                    <div class="flex-1 min-w-0 text-right">
                                        <div class="flex items-center justify-end gap-2 mb-1">
                                            <span class="text-xs text-gray-400">{{ $song->serial_number ?? 'N/A' }}</span>
                                            <button onclick="copySongLink{{ $index }}()" class="flex items-center gap-1 px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded text-xs transition-all active:scale-95" title="Salin link lagu">
                                                <svg id="copyIcon{{ $index }}" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                <span id="copyText{{ $index }}" class="font-medium">Salin Link</span>
                                                <svg id="checkIcon{{ $index }}" class="hidden w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                </svg>
                                                <span id="checkText{{ $index }}" class="hidden font-medium text-green-600">Tersalin!</span>
                                            </button>
                                        </div>
                                        <h3 class="font-bold text-gray-900 truncate"><span class="text-gray-500 font-normal">Judul:</span> {{ $song->title }}</h3>
                                        <p class="text-sm text-gray-600 truncate"><span class="text-gray-400">Cipt:</span> {{ $song->artist }}</p>
                                    </div>
                                    
                                    <!-- Cover Image (optional) -->
                                    @if($song->cover_image)
                                        <img src="{{ $song->cover_url }}" alt="Cover" class="hidden md:block w-16 h-16 rounded object-cover flex-shrink-0">
                                    @endif
                                </div>
                                
                                <!-- Progress Bar (Always visible) -->
                                <div id="progressContainer{{ $index }}">
                                    <div class="flex items-center gap-3">
                                        <span id="currentTime{{ $index }}" class="text-xs text-gray-500 w-10 text-right">0:00</span>
                                        <div class="flex-1 bg-gray-200 rounded-full h-1 cursor-pointer" onclick="seekAudio{{ $index }}(event)">
                                            <div id="progressBar{{ $index }}" class="bg-black h-1 rounded-full transition-all" style="width: 0%"></div>
                                        </div>
                                        <span id="duration{{ $index }}" class="text-xs text-gray-500 w-10">0:00</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Hidden Audio Player -->
                            @if($song->audio_file)
                                <audio id="audio{{ $index }}" class="hidden" preload="metadata">
                                    <source src="{{ $song->audio_url }}" type="audio/mpeg">
                                </audio>
                            @endif
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $songs->links() }}
                </div>
            @else
                <div class="text-center py-20">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <p class="text-gray-500">Belum ada lagu</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        let currentAudio = null;
        let currentIndex = null;
        
        // Disable right-click on audio elements
        document.addEventListener('contextmenu', function(e) {
            if (e.target.tagName === 'AUDIO' || e.target.closest('audio')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable keyboard shortcuts for dev tools
        document.addEventListener('keydown', function(e) {
            // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
            if (e.keyCode === 123 || 
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) ||
                (e.ctrlKey && e.keyCode === 85)) {
                e.preventDefault();
                return false;
            }
        });
        
        // Detect dev tools (warning only, not blocking)
        (function() {
            const devtools = /./;
            devtools.toString = function() {
                console.warn('⚠️ Audio files are protected. Unauthorized download is prohibited.');
            };
            console.log('%c', devtools);
        })();
        
        // Format time helper
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return mins + ':' + (secs < 10 ? '0' : '') + secs;
        }
        
        // Auto-scroll to song if hash in URL
        window.addEventListener('load', function() {
            if (window.location.hash) {
                const element = document.querySelector(window.location.hash);
                if (element) {
                    setTimeout(function() {
                        element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        element.classList.add('ring-2', 'ring-blue-500');
                        setTimeout(function() {
                            element.classList.remove('ring-2', 'ring-blue-500');
                        }, 3000);
                    }, 100);
                }
            }
        });

        
        @foreach($songs as $index => $song)
        // Copy song link function
        function copySongLink{{ $index }}() {
            const url = '{{ route('song.show', $song->slug) }}';
            
            navigator.clipboard.writeText(url).then(function() {
                // Show check icon and text
                const copyIcon = document.getElementById('copyIcon{{ $index }}');
                const checkIcon = document.getElementById('checkIcon{{ $index }}');
                const copyText = document.getElementById('copyText{{ $index }}');
                const checkText = document.getElementById('checkText{{ $index }}');
                
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
                copyText.classList.add('hidden');
                checkText.classList.remove('hidden');
                
                // Reset after 2 seconds
                setTimeout(function() {
                    copyIcon.classList.remove('hidden');
                    checkIcon.classList.add('hidden');
                    copyText.classList.remove('hidden');
                    checkText.classList.add('hidden');
                }, 2000);
            }).catch(function(err) {
                alert('Gagal copy link: ' + err);
            });
        }
        
        // Load duration on page load
        (function() {
            const audio = document.getElementById('audio{{ $index }}');
            const durationEl = document.getElementById('duration{{ $index }}');
            
            if (audio && durationEl) {
                audio.addEventListener('loadedmetadata', function() {
                    durationEl.textContent = formatTime(audio.duration);
                });
                
                // Trigger load if already loaded
                if (audio.readyState >= 1) {
                    durationEl.textContent = formatTime(audio.duration);
                }
            }
        })();
        
        function togglePlay{{ $index }}() {
            const audio = document.getElementById('audio{{ $index }}');
            const playIcon = document.getElementById('playIcon{{ $index }}');
            const pauseIcon = document.getElementById('pauseIcon{{ $index }}');
            const progressContainer = document.getElementById('progressContainer{{ $index }}');
            const progressBar = document.getElementById('progressBar{{ $index }}');
            const currentTimeEl = document.getElementById('currentTime{{ $index }}');
            const durationEl = document.getElementById('duration{{ $index }}');
            
            if (!audio) return;
            
            // If this song is already playing, pause it
            if (currentAudio === audio && !audio.paused) {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                return;
            }
            
            // Stop and reset previous song
            if (currentAudio && currentAudio !== audio) {
                currentAudio.pause();
                currentAudio.currentTime = 0;
                if (currentIndex !== null) {
                    document.getElementById('playIcon' + currentIndex).classList.remove('hidden');
                    document.getElementById('pauseIcon' + currentIndex).classList.add('hidden');
                    document.getElementById('progressBar' + currentIndex).style.width = '0%';
                    
                    // Hide restart button
                    const prevRestart = document.getElementById('restartBtn' + currentIndex);
                    if (prevRestart) {
                        prevRestart.classList.add('hidden');
                    }
                    
                    // Reset lyrics to default text
                    const prevLyric = document.getElementById('currentLyric' + currentIndex);
                    if (prevLyric) {
                        prevLyric.textContent = '...';
                    }
                }
            }
            
            // Play new song
            audio.play();
            currentAudio = audio;
            currentIndex = {{ $index }};
            playIcon.classList.add('hidden');
            pauseIcon.classList.remove('hidden');
            
            // Show restart button
            const restartBtn = document.getElementById('restartBtn{{ $index }}');
            if (restartBtn) {
                restartBtn.classList.remove('hidden');
            }

            // Update duration when loaded
            audio.onloadedmetadata = function() {
                durationEl.textContent = formatTime(audio.duration);
            };
            
            // Update progress bar and lyrics
            audio.ontimeupdate = function() {
                const progress = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = progress + '%';
                currentTimeEl.textContent = formatTime(audio.currentTime);
                
                // Update synchronized lyrics
                updateLyrics{{ $index }}(audio.currentTime);
            };
            
            // Listen for audio end
            audio.onended = function() {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                progressBar.style.width = '0%';
                currentTimeEl.textContent = '0:00';
                
                // Remove animated border when song ends
                const songCard = document.getElementById('song{{ $index }}');
                if (songCard) {
                    songCard.classList.remove('playing-border');
                }
            };
        }
        
        function seekAudio{{ $index }}(event) {
            const audio = document.getElementById('audio{{ $index }}');
            if (!audio || audio !== currentAudio) return;
            
            const progressContainer = event.currentTarget;
            const clickX = event.offsetX;
            const width = progressContainer.offsetWidth;
            const percentage = clickX / width;
            
            audio.currentTime = audio.duration * percentage;
        }
        
        function jumpToMarker{{ $index }}(time) {
            const audio = document.getElementById('audio{{ $index }}');
            if (!audio) return;
            
            // If not playing, start playing
            if (audio !== currentAudio || audio.paused) {
                togglePlay{{ $index }}();
            }
            
            // Jump to marker time
            audio.currentTime = time;
        }
        
        // Restart audio from beginning
        function restartAudio{{ $index }}() {
            const audio = document.getElementById('audio{{ $index }}');
            if (!audio) return;
            
            audio.currentTime = 0;
            
            // If not playing, start playing
            if (audio.paused) {
                togglePlay{{ $index }}();
            }
        }
        
        // Update synchronized lyrics with smooth animation
        let lastLyric{{ $index }} = '';
        function updateLyrics{{ $index }}(currentTime) {
            @if($song->lyrics && count($song->lyrics) > 0)
            const lyricsData = [
                @foreach($song->lyrics as $lyricIndex => $lyric)
                { text: "{{ addslashes($lyric['text']) }}", time: {{ $lyric['time'] }} },
                @endforeach
            ];
            
            // Find current lyric
            let currentLyric = '';
            for (let i = lyricsData.length - 1; i >= 0; i--) {
                if (currentTime >= lyricsData[i].time) {
                    currentLyric = lyricsData[i].text;
                    break;
                }
            }
            
            // Only update if lyric changed
            if (currentLyric && currentLyric !== lastLyric{{ $index }}) {
                lastLyric{{ $index }} = currentLyric;
                
                // Update mobile display with animation
                const lyricMobile = document.getElementById('currentLyric{{ $index }}');
                if (lyricMobile) {
                    lyricMobile.style.opacity = '0';
                    lyricMobile.style.transform = 'scale(0.95) translateY(-5px)';
                    
                    setTimeout(() => {
                        lyricMobile.textContent = currentLyric;
                        lyricMobile.style.opacity = '1';
                        lyricMobile.style.transform = 'scale(1) translateY(0)';
                    }, 250);
                }
                
                // Update desktop display with animation
                const lyricDesktop = document.getElementById('currentLyricDesktop{{ $index }}');
                if (lyricDesktop) {
                    lyricDesktop.style.opacity = '0';
                    lyricDesktop.style.transform = 'scale(0.95) translateY(-5px)';
                    
                    setTimeout(() => {
                        lyricDesktop.textContent = currentLyric;
                        lyricDesktop.style.opacity = '1';
                        lyricDesktop.style.transform = 'scale(1) translateY(0)';
                    }, 250);
                }
            }
            @endif
        }
        @endforeach
    </script>
</x-layouts.app>
