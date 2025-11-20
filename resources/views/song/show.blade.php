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
                <h1 class="text-4xl md:text-5xl font-bold mb-3">{{ $song->title }}</h1>
                <p class="text-gray-300 mb-3">Cipt: {{ $song->artist }}</p>
                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-400 mb-3">
                    <span class="font-semibold text-white">{{ $song->serial_number ?? 'N/A' }}</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                        </svg>
                        {{ number_format($song->views) }} views
                    </span>
                </div>
                <a href="{{ route('song.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-300 hover:text-white transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke semua lagu
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="container mx-auto max-w-4xl px-6 py-8">
            <div class="bg-white border border-gray-200 rounded-lg shadow-md">
                <div class="p-6">
                    <!-- Lyrics Display -->
                    @if($song->lyrics && count($song->lyrics) > 0)
                    <div id="lyricsDisplay" class="mb-4">
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-lg p-6">
                            <p id="currentLyric" class="text-xl font-semibold text-gray-800 text-center min-h-[4rem] flex items-center justify-center transition-all duration-500 ease-in-out transform">
                                ...
                            </p>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Markers -->
                    @if($song->markers && count($song->markers) > 0)
                    <div class="mb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="text-xs text-gray-500 italic">💡 Tekan untuk loncat ke bagian lagu:</span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($song->markers as $marker)
                            <button onclick="jumpToMarker({{ $marker['time'] }})" 
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-full transition active:scale-95">
                                {{ $marker['label'] }}
                            </button>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <!-- Player Controls -->
                    <div class="flex items-center justify-center gap-4 mb-4">
                        <button onclick="togglePlay()" class="w-16 h-16 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center transition-all hover:scale-105">
                            <svg id="playIcon" class="w-7 h-7 text-white ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                            </svg>
                            <svg id="pauseIcon" class="hidden w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </button>
                        
                        <button id="restartBtn" onclick="restartAudio()" class="hidden w-12 h-12 bg-black hover:bg-gray-800 rounded-full flex items-center justify-center transition-all hover:scale-105">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Progress Bar -->
                    <div class="mb-3">
                        <div class="flex items-center gap-3">
                            <span id="currentTime" class="text-sm text-gray-500 w-12 text-right">0:00</span>
                            <div class="flex-1 bg-gray-200 rounded-full h-2 cursor-pointer" onclick="seekAudio(event)">
                                <div id="progressBar" class="bg-black h-2 rounded-full transition-all" style="width: 0%"></div>
                            </div>
                            <span id="duration" class="text-sm text-gray-500 w-12">0:00</span>
                        </div>
                    </div>
                    
                    <!-- Copy Link Button -->
                    <button onclick="copySongLink()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all active:scale-95">
                        <svg id="copyIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span id="copyText" class="text-sm font-medium">Salin Link</span>
                        <svg id="checkIcon" class="hidden w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span id="checkText" class="hidden text-sm font-medium text-green-600">Tersalin!</span>
                    </button>
                </div>
            </div>
            
            <!-- Hidden Audio Player -->
            @if($song->audio_file)
                <audio id="audio" class="hidden" preload="metadata">
                    <source src="{{ $song->audio_url }}" type="audio/mpeg">
                </audio>
            @endif
        </div>
    </div>

    <script>
        // Disable right-click on audio elements
        document.addEventListener('contextmenu', function(e) {
            if (e.target.tagName === 'AUDIO' || e.target.closest('audio')) {
                e.preventDefault();
                return false;
            }
        });
        
        // Disable keyboard shortcuts for dev tools
        document.addEventListener('keydown', function(e) {
            if (e.keyCode === 123 || 
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74)) ||
                (e.ctrlKey && e.keyCode === 85)) {
                e.preventDefault();
                return false;
            }
        });
        
        // Detect dev tools warning
        (function() {
            const devtools = /./;
            devtools.toString = function() {
                console.warn('⚠️ Audio files are protected. Unauthorized download is prohibited.');
            };
            console.log('%c', devtools);
        })();
        
        const audio = document.getElementById('audio');
        const playIcon = document.getElementById('playIcon');
        const pauseIcon = document.getElementById('pauseIcon');
        const progressBar = document.getElementById('progressBar');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');
        const restartBtn = document.getElementById('restartBtn');
        
        function formatTime(seconds) {
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return mins + ':' + (secs < 10 ? '0' : '') + secs;
        }
        
        if (audio) {
            audio.addEventListener('loadedmetadata', function() {
                durationEl.textContent = formatTime(audio.duration);
            });
            
            audio.addEventListener('timeupdate', function() {
                const progress = (audio.currentTime / audio.duration) * 100;
                progressBar.style.width = progress + '%';
                currentTimeEl.textContent = formatTime(audio.currentTime);
                updateLyrics(audio.currentTime);
            });
            
            audio.addEventListener('ended', function() {
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
                progressBar.style.width = '0%';
                currentTimeEl.textContent = '0:00';
            });
        }
        
        function togglePlay() {
            if (!audio) return;
            
            if (audio.paused) {
                audio.play();
                playIcon.classList.add('hidden');
                pauseIcon.classList.remove('hidden');
                restartBtn.classList.remove('hidden');
            } else {
                audio.pause();
                playIcon.classList.remove('hidden');
                pauseIcon.classList.add('hidden');
            }
        }
        
        function restartAudio() {
            if (!audio) return;
            audio.currentTime = 0;
            if (audio.paused) {
                togglePlay();
            }
        }
        
        function seekAudio(event) {
            if (!audio) return;
            const progressContainer = event.currentTarget;
            const clickX = event.offsetX;
            const width = progressContainer.offsetWidth;
            const percentage = clickX / width;
            audio.currentTime = audio.duration * percentage;
        }
        
        function jumpToMarker(time) {
            if (!audio) return;
            if (audio.paused) {
                togglePlay();
            }
            audio.currentTime = time;
        }
        
        let lastLyric = '';
        function updateLyrics(currentTime) {
            @if($song->lyrics && count($song->lyrics) > 0)
            const lyricsData = [
                @foreach($song->lyrics as $lyric)
                { text: "{{ addslashes($lyric['text']) }}", time: {{ $lyric['time'] }} },
                @endforeach
            ];
            
            let currentLyric = '';
            for (let i = lyricsData.length - 1; i >= 0; i--) {
                if (currentTime >= lyricsData[i].time) {
                    currentLyric = lyricsData[i].text;
                    break;
                }
            }
            
            if (currentLyric && currentLyric !== lastLyric) {
                lastLyric = currentLyric;
                const lyricDisplay = document.getElementById('currentLyric');
                if (lyricDisplay) {
                    lyricDisplay.style.opacity = '0';
                    lyricDisplay.style.transform = 'scale(0.95) translateY(-5px)';
                    
                    setTimeout(() => {
                        lyricDisplay.textContent = currentLyric;
                        lyricDisplay.style.opacity = '1';
                        lyricDisplay.style.transform = 'scale(1) translateY(0)';
                    }, 250);
                }
            }
            @endif
        }
        
        function copySongLink() {
            const url = window.location.href;
            
            navigator.clipboard.writeText(url).then(function() {
                const copyIcon = document.getElementById('copyIcon');
                const checkIcon = document.getElementById('checkIcon');
                const copyText = document.getElementById('copyText');
                const checkText = document.getElementById('checkText');
                
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
                copyText.classList.add('hidden');
                checkText.classList.remove('hidden');
                
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
    </script>
</x-layouts.app>
