<x-layouts.app>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, .font-display {
            font-family: 'Poppins', sans-serif;
        }
        #fretboardEditor, #fretboardPreview {
            max-width: 100%;
            height: auto;
        }
        #quickChordPanel {
            transition: opacity 0.3s ease-in-out;
        }
        #quickChordPanel:not(.hidden) {
            animation: fadeIn 0.3s ease-in-out;
        }
        #quickChordPanel > div:last-child {
            animation: slideUp 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { 
                transform: translateY(100%);
                opacity: 0;
            }
            to { 
                transform: translateY(0);
                opacity: 1;
            }
        }
        @media (min-width: 640px) {
            #quickChordPanel > div:last-child {
                animation: slideInRight 0.3s ease-out;
            }
            @keyframes slideInRight {
                from { 
                    transform: translateX(100%);
                    opacity: 0;
                }
                to { 
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        }

    </style>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-8">
            <!-- Header -->
            <div class="mb-6 sm:mb-8 text-center">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-2 tracking-tight">FretBubble</h1>
                <p class="text-sm sm:text-base text-gray-600">Buat diagram chord gitar dengan mudah</p>
            </div>

            <!-- Floating Quick Chord Button -->
            <button onclick="toggleQuickChord()" 
                class="fixed bottom-6 right-6 z-[70] bg-gray-900 text-white px-4 py-3 rounded-full shadow-2xl hover:bg-black hover:shadow-3xl hover:scale-105 transition-all duration-300 flex items-center gap-2 group">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                </svg>
                <span class="text-sm font-bold">Quick Chord</span>
            </button>

            <!-- Floating Quick Chord Panel -->
            <div id="quickChordPanel" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
                <!-- Backdrop -->
                <div onclick="toggleQuickChord()" class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
                
                <!-- Panel -->
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[80vh] overflow-hidden flex flex-col border-2 border-black">
                    <!-- Header -->
                    <div class="flex items-center justify-between p-4 border-b-2 border-black bg-white">
                        <h2 class="text-lg font-bold text-gray-900">
                            Quick Chord
                        </h2>
                        <button onclick="toggleQuickChord()" class="text-gray-500 hover:text-gray-700 p-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="overflow-y-auto p-4 flex-1">
                        <!-- Difficulty Toggle -->
                        <div class="mb-4 flex gap-2">
                            <button onclick="setDifficulty('simple')" id="btnSimple"
                                class="flex-1 px-4 py-2 bg-black text-white font-medium text-sm border-2 border-black transition">
                                Simple
                            </button>
                            <button onclick="setDifficulty('advanced')" id="btnAdvanced"
                                class="flex-1 px-4 py-2 bg-white text-black font-medium text-sm border-2 border-black hover:bg-gray-100 transition">
                                Advanced
                            </button>
                        </div>

                        <div class="grid grid-cols-2 gap-2 mb-4">
                            @foreach($families as $family)
                                <button onclick="loadChordFamily('{{ $family }}')" 
                                    class="px-3 py-2.5 bg-white hover:bg-gray-100 font-medium transition-all duration-200 text-sm border-2 border-black hover:bg-black hover:text-white">
                                    {{ $family }} Family
                                </button>
                            @endforeach
                        </div>
                        <div id="chordList" class="grid grid-cols-1 gap-2 hidden">
                            <!-- Chord buttons will be loaded here -->
                        </div>
                        <div class="mt-4 flex flex-col gap-2 hidden" id="bulkActions">
                            <button onclick="selectAllChords()" 
                                class="px-4 py-2 bg-black text-white hover:bg-gray-800 transition text-sm font-medium border-2 border-black">
                                Select All
                            </button>
                            <button onclick="deselectAllChords()" 
                                class="px-4 py-2 bg-white text-black border-2 border-black hover:bg-gray-100 transition text-sm font-medium">
                                Deselect All
                            </button>
                            <button onclick="bulkDownload()" 
                                class="px-4 py-2 bg-black text-white hover:bg-gray-800 transition text-sm font-medium border-2 border-black">
                                Download Selected
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                <!-- Editor Panel -->
                <div class="bg-white border-2 border-black shadow-md p-4 sm:p-6">
                    <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Editor</h2>
                    
                    <!-- Settings Form -->
                    <div class="space-y-3 sm:space-y-4 mb-4 sm:mb-6">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Nama Chord</label>
                            <input type="text" id="chordTitle" value="Em" 
                                class="w-full px-3 py-2 text-sm sm:text-base border-2 border-black focus:ring-2 focus:ring-black/20 transition">
                        </div>

                        <div class="grid grid-cols-2 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Jumlah Fret</label>
                                <input type="number" id="numFrets" value="5" min="3" max="12"
                                    class="w-full px-3 py-2 text-sm sm:text-base border-2 border-black focus:ring-2 focus:ring-black/20 transition">
                            </div>
                            <div>
                                <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Jumlah Senar</label>
                                <input type="number" id="numStrings" value="6" min="4" max="8"
                                    class="w-full px-3 py-2 text-sm sm:text-base border-2 border-black focus:ring-2 focus:ring-black/20 transition">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Starting Fret</label>
                            <input type="number" id="startingFret" value="0" min="0" max="20"
                                class="w-full px-3 py-2 text-sm sm:text-base border-2 border-black focus:ring-2 focus:ring-black/20 transition">
                        </div>

                        <!-- Color Settings -->
                        <div class="border-t pt-3 sm:pt-4 mt-3 sm:mt-4">
                            <h3 class="text-xs sm:text-sm font-semibold text-gray-900 mb-2 sm:mb-3 fretbubble-title">Warna</h3>
                            <div class="grid grid-cols-2 gap-3 sm:gap-4">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Background</label>
                                    <input type="color" id="bgColor" value="#ffffff"
                                        class="w-full h-10 sm:h-12 border-2 border-black cursor-pointer hover:border-gray-700 transition">
                                </div>
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-900 mb-1">Foreground</label>
                                    <input type="color" id="fgColor" value="#000000"
                                        class="w-full h-10 sm:h-12 border-2 border-black cursor-pointer hover:border-gray-700 transition">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Fretboard -->
                    <div class="border-2 border-black p-3 sm:p-4 bg-white">
                        <canvas id="fretboardEditor" class="w-full cursor-pointer"></canvas>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-3 sm:mt-4 flex flex-wrap gap-2">
                        <button onclick="clearFingers()" 
                            class="flex-1 sm:flex-none px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-black bg-white border-2 border-black hover:bg-black hover:text-white transition-all">
                            Reset
                        </button>
                        <button onclick="toggleMute()" 
                            class="flex-1 sm:flex-none px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium text-black bg-white border-2 border-black hover:bg-black hover:text-white transition-all">
                            Toggle Mute (X)
                        </button>
                    </div>
                </div>

                <!-- Result Panel (Sticky) -->
                <div class="lg:sticky lg:top-6 lg:self-start">
                    <div class="bg-white border-2 border-black shadow-md p-4 sm:p-6">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 fretbubble-title">Preview</h2>
                            <button onclick="refreshPreview()" 
                                class="text-xs sm:text-sm text-black hover:text-gray-700 font-medium underline">
                                Refresh
                            </button>
                        </div>
                        
                        <!-- Preview Canvas -->
                        <div class="border-2 border-black p-4 sm:p-6 bg-white mb-3 sm:mb-4 shadow-sm">
                            <canvas id="fretboardPreview" class="w-full"></canvas>
                        </div>

                        <!-- Download Options -->
                        <div class="space-y-2">
                            <h3 class="text-xs sm:text-sm font-medium text-gray-700 mb-2 fretbubble-title">Download</h3>
                            <button onclick="downloadImage('png')" 
                                class="w-full px-4 py-2.5 text-sm font-medium text-white bg-black border-2 border-black hover:bg-gray-800 transition-all">
                                Download PNG
                            </button>
                            <button onclick="downloadImage('svg')" 
                                class="w-full px-4 py-2.5 text-sm font-medium text-black bg-white border-2 border-black hover:bg-gray-100 transition-all">
                                Download SVG
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Button (Bottom Left) -->
            <button onclick="toggleHelp()" 
                class="fixed bottom-6 left-6 z-[70] bg-white text-black p-4 rounded-full shadow-2xl hover:bg-gray-100 border-2 border-black hover:scale-105 transition-all duration-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </button>

            <!-- Help Panel -->
            <div id="helpPanel" class="fixed inset-0 z-[60] hidden flex items-center justify-center p-4">
                <div onclick="toggleHelp()" class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm"></div>
                <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md max-h-[80vh] overflow-hidden flex flex-col border-2 border-black">
                    <div class="flex items-center justify-between p-4 border-b-2 border-black bg-white">
                        <h2 class="text-lg font-bold text-gray-900">Cara Pakai</h2>
                        <button onclick="toggleHelp()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="overflow-y-auto p-4">
                        <ul class="list-disc list-inside text-gray-700 space-y-2 text-sm">
                            <li>Klik pada fretboard untuk menambah/menghapus posisi jari</li>
                            <li>Klik di atas nut (fret 0) untuk menandai senar terbuka (O)</li>
                            <li>Gunakan tombol "Toggle Mute" untuk menandai senar yang tidak dimainkan (X)</li>
                            <li>Sesuaikan jumlah fret dan senar sesuai kebutuhan</li>
                            <li>Pilih warna background dan foreground</li>
                            <li>Download hasil diagram dalam format PNG atau SVG</li>
                            <li>Gunakan Quick Chord untuk memilih preset chord populer</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // State management
        let fingers = [];
        let openStrings = [];
        let mutedStrings = [];
        let muteMode = false;

        // Canvas references
        const editorCanvas = document.getElementById('fretboardEditor');
        const previewCanvas = document.getElementById('fretboardPreview');
        const editorCtx = editorCanvas.getContext('2d');
        const previewCtx = previewCanvas.getContext('2d');

        // Settings
        function getSettings() {
            return {
                title: document.getElementById('chordTitle').value,
                numFrets: parseInt(document.getElementById('numFrets').value),
                numStrings: parseInt(document.getElementById('numStrings').value),
                startingFret: parseInt(document.getElementById('startingFret').value),
                bgColor: document.getElementById('bgColor').value,
                fgColor: document.getElementById('fgColor').value
            };
        }

        // Draw fretboard
        function drawFretboard(ctx, canvas, isEditor = false) {
            const settings = getSettings();
            const paddingTop = 100;
            const paddingBottom = 60;
            const paddingSide = 80;
            const width = canvas.width - (paddingSide * 2);
            const height = canvas.height - paddingTop - paddingBottom;
            const stringSpacing = width / (settings.numStrings - 1);
            const fretSpacing = height / settings.numFrets;

            // Clear canvas with background color
            ctx.fillStyle = settings.bgColor;
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw title with responsive font
            const titleSize = Math.max(24, Math.min(32, canvas.width / 17));
            ctx.font = `bold ${titleSize}px 'Poppins', sans-serif`;
            ctx.fillStyle = settings.fgColor;
            ctx.textAlign = 'center';
            ctx.fillText(settings.title, canvas.width / 2, titleSize + 13);

            // Draw strings (vertical lines)
            ctx.strokeStyle = settings.fgColor;
            for (let i = 0; i < settings.numStrings; i++) {
                const x = paddingSide + (i * stringSpacing);
                ctx.lineWidth = 1.5 + (i * 0.2);
                ctx.beginPath();
                ctx.moveTo(x, paddingTop);
                ctx.lineTo(x, paddingTop + height);
                ctx.stroke();
            }

            // Draw frets (horizontal lines)
            ctx.strokeStyle = settings.fgColor;
            for (let i = 0; i <= settings.numFrets; i++) {
                const y = paddingTop + (i * fretSpacing);
                ctx.lineWidth = i === 0 && settings.startingFret === 0 ? 6 : 2;
                ctx.beginPath();
                ctx.moveTo(paddingSide, y);
                ctx.lineTo(paddingSide + width, y);
                ctx.stroke();
            }

            // Draw open/muted strings (di atas)
            const symbolSize = Math.max(16, Math.min(20, canvas.width / 27));
            ctx.font = `${symbolSize}px 'Inter', sans-serif`;
            ctx.textAlign = 'center';
            for (let i = 0; i < settings.numStrings; i++) {
                const x = paddingSide + (i * stringSpacing);
                const y = paddingTop - 25;
                
                if (openStrings.includes(i)) {
                    ctx.strokeStyle = settings.fgColor;
                    ctx.lineWidth = 2.5;
                    ctx.beginPath();
                    ctx.arc(x, y, 12, 0, Math.PI * 2);
                    ctx.stroke();
                } else if (mutedStrings.includes(i)) {
                    ctx.fillStyle = settings.fgColor;
                    ctx.fillText('×', x, y + 7);
                }
            }

            // Draw fingers
            ctx.fillStyle = settings.fgColor;
            fingers.forEach(finger => {
                const x = paddingSide + (finger.string * stringSpacing);
                const y = paddingTop + (finger.fret * fretSpacing) - (fretSpacing / 2);
                ctx.beginPath();
                ctx.arc(x, y, 18, 0, Math.PI * 2);
                ctx.fill();
            });

            // Draw fret numbers on left side (after fingers so they appear on top)
            const fretNumSize = Math.max(11, Math.min(14, canvas.width / 40));
            ctx.font = `bold ${fretNumSize}px 'Inter', sans-serif`;
            ctx.textAlign = 'right';
            for (let i = 1; i <= settings.numFrets; i++) {
                const y = paddingTop + (i * fretSpacing) - (fretSpacing / 2);
                const fretNum = settings.startingFret + i;
                const textX = paddingSide - 25;
                const textY = y + 5;
                
                // Draw white background for number
                const textWidth = ctx.measureText(fretNum.toString()).width;
                ctx.fillStyle = settings.bgColor;
                ctx.fillRect(textX - textWidth - 4, textY - fretNumSize, textWidth + 8, fretNumSize + 4);
                
                // Draw number
                ctx.fillStyle = settings.fgColor;
                ctx.fillText(fretNum.toString(), textX, textY);
            }

            // Draw starting fret label (e.g., "7fr") on the right side
            if (settings.startingFret > 0) {
                const labelSize = Math.max(16, Math.min(20, canvas.width / 27));
                ctx.font = `bold ${labelSize}px 'Poppins', sans-serif`;
                ctx.fillStyle = settings.fgColor;
                ctx.textAlign = 'left';
                const labelY = paddingTop + (fretSpacing / 2);
                ctx.fillText(settings.startingFret + 'fr', paddingSide + width + 20, labelY + 5);
            }

            // Draw string numbers at the bottom (6-1 from left to right, standard guitar notation)
            const stringNumSize = Math.max(12, Math.min(16, canvas.width / 35));
            ctx.font = `bold ${stringNumSize}px 'Inter', sans-serif`;
            ctx.fillStyle = settings.fgColor;
            ctx.textAlign = 'center';
            for (let i = 0; i < settings.numStrings; i++) {
                const x = paddingSide + (i * stringSpacing);
                const y = paddingTop + height + 35;
                // String 6 (E low) on left, String 1 (E high) on right
                ctx.fillText((settings.numStrings - i).toString(), x, y);
            }

            return { paddingTop, paddingSide, stringSpacing, fretSpacing, width, height };
        }

        // Initialize canvases with responsive sizing
        function initCanvases() {
            const containerWidth = Math.min(editorCanvas.parentElement.clientWidth, 550);
            const canvasWidth = containerWidth;
            const canvasHeight = canvasWidth * 1.18; // Maintain aspect ratio
            
            editorCanvas.width = canvasWidth;
            editorCanvas.height = canvasHeight;
            previewCanvas.width = canvasWidth;
            previewCanvas.height = canvasHeight;
            
            drawFretboard(editorCtx, editorCanvas, true);
            drawFretboard(previewCtx, previewCanvas, false);
        }

        // Responsive resize
        window.addEventListener('resize', () => {
            initCanvases();
        });

        // Handle canvas click
        editorCanvas.addEventListener('click', (e) => {
            const rect = editorCanvas.getBoundingClientRect();
            // Scale coordinates properly
            const scaleX = editorCanvas.width / rect.width;
            const scaleY = editorCanvas.height / rect.height;
            const x = (e.clientX - rect.left) * scaleX;
            const y = (e.clientY - rect.top) * scaleY;
            
            const settings = getSettings();
            const paddingTop = 100;
            const paddingBottom = 60;
            const paddingSide = 80;
            const width = editorCanvas.width - (paddingSide * 2);
            const height = editorCanvas.height - paddingTop - paddingBottom;
            const stringSpacing = width / (settings.numStrings - 1);
            const fretSpacing = height / settings.numFrets;

            // Check if click is above nut (open string area)
            if (y < paddingTop && y > paddingTop - 50) {
                const stringIndex = Math.round((x - paddingSide) / stringSpacing);
                if (stringIndex >= 0 && stringIndex < settings.numStrings) {
                    if (muteMode) {
                        toggleMutedString(stringIndex);
                    } else {
                        toggleOpenString(stringIndex);
                    }
                    drawFretboard(editorCtx, editorCanvas, true);
                    refreshPreview();
                    return;
                }
            }

            // Find closest string and fret
            const stringIndex = Math.round((x - paddingSide) / stringSpacing);
            const fretIndex = Math.round((y - paddingTop) / fretSpacing);

            if (stringIndex >= 0 && stringIndex < settings.numStrings && 
                fretIndex > 0 && fretIndex <= settings.numFrets) {
                
                toggleFinger(stringIndex, fretIndex);
                drawFretboard(editorCtx, editorCanvas, true);
                refreshPreview();
            }
        });

        // Toggle finger position
        function toggleFinger(string, fret) {
            const index = fingers.findIndex(f => f.string === string && f.fret === fret);
            if (index > -1) {
                fingers.splice(index, 1);
            } else {
                // Remove other fingers on same string
                fingers = fingers.filter(f => f.string !== string);
                fingers.push({ string, fret });
                
                // Remove from open/muted if adding finger
                openStrings = openStrings.filter(s => s !== string);
                mutedStrings = mutedStrings.filter(s => s !== string);
            }
        }

        // Toggle open string
        function toggleOpenString(string) {
            const index = openStrings.indexOf(string);
            if (index > -1) {
                openStrings.splice(index, 1);
            } else {
                openStrings.push(string);
                mutedStrings = mutedStrings.filter(s => s !== string);
                fingers = fingers.filter(f => f.string !== string);
            }
        }

        // Toggle muted string
        function toggleMutedString(string) {
            const index = mutedStrings.indexOf(string);
            if (index > -1) {
                mutedStrings.splice(index, 1);
            } else {
                mutedStrings.push(string);
                openStrings = openStrings.filter(s => s !== string);
                fingers = fingers.filter(f => f.string !== string);
            }
        }

        // Clear all fingers
        function clearFingers() {
            fingers = [];
            openStrings = [];
            mutedStrings = [];
            drawFretboard(editorCtx, editorCanvas, true);
            refreshPreview();
        }

        // Toggle mute mode
        function toggleMute() {
            muteMode = !muteMode;
            event.target.classList.toggle('bg-blue-600', muteMode);
            event.target.classList.toggle('text-white', muteMode);
            event.target.classList.toggle('bg-gray-100', !muteMode);
            event.target.classList.toggle('text-gray-700', !muteMode);
        }

        // Refresh preview
        function refreshPreview() {
            drawFretboard(previewCtx, previewCanvas, false);
        }

        // Download image
        function downloadImage(format) {
            const settings = getSettings();
            const filename = `${settings.title.replace(/\s+/g, '_')}_chord.${format}`;
            
            if (format === 'png') {
                const link = document.createElement('a');
                link.download = filename;
                link.href = previewCanvas.toDataURL('image/png');
                link.click();
            } else if (format === 'svg') {
                // For SVG, we'll use a simple conversion
                alert('SVG export akan segera hadir! Sementara gunakan PNG.');
            }
        }

        // Listen to input changes
        document.getElementById('chordTitle').addEventListener('input', () => {
            drawFretboard(editorCtx, editorCanvas, true);
            refreshPreview();
        });

        document.getElementById('numFrets').addEventListener('change', () => {
            fingers = [];
            initCanvases();
        });

        document.getElementById('numStrings').addEventListener('change', () => {
            fingers = [];
            openStrings = [];
            mutedStrings = [];
            initCanvases();
        });

        document.getElementById('startingFret').addEventListener('change', () => {
            drawFretboard(editorCtx, editorCanvas, true);
            refreshPreview();
        });

        // Color pickers
        ['bgColor', 'fgColor'].forEach(colorId => {
            document.getElementById(colorId).addEventListener('input', () => {
                drawFretboard(editorCtx, editorCanvas, true);
                refreshPreview();
            });
        });

        // Initialize on load
        initCanvases();

        // Example: Load Em chord
        fingers = [
            { string: 1, fret: 2 },
            { string: 2, fret: 2 }
        ];
        openStrings = [0, 3, 4, 5];
        drawFretboard(editorCtx, editorCanvas, true);
        refreshPreview();

        // Toggle Quick Chord Panel
        function toggleQuickChord() {
            const panel = document.getElementById('quickChordPanel');
            panel.classList.toggle('hidden');
            document.body.style.overflow = panel.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        // Toggle Help Panel
        function toggleHelp() {
            const panel = document.getElementById('helpPanel');
            panel.classList.toggle('hidden');
            document.body.style.overflow = panel.classList.contains('hidden') ? 'auto' : 'hidden';
        }

        // Quick Chord functionality
        let selectedChords = [];
        let currentChords = [];
        let currentDifficulty = 'simple';

        function setDifficulty(difficulty) {
            currentDifficulty = difficulty;
            
            // Update button styles
            const btnSimple = document.getElementById('btnSimple');
            const btnAdvanced = document.getElementById('btnAdvanced');
            
            if (difficulty === 'simple') {
                btnSimple.className = 'flex-1 px-4 py-2 bg-black text-white font-medium text-sm border-2 border-black transition';
                btnAdvanced.className = 'flex-1 px-4 py-2 bg-white text-black font-medium text-sm border-2 border-black hover:bg-gray-100 transition';
            } else {
                btnSimple.className = 'flex-1 px-4 py-2 bg-white text-black font-medium text-sm border-2 border-black hover:bg-gray-100 transition';
                btnAdvanced.className = 'flex-1 px-4 py-2 bg-black text-white font-medium text-sm border-2 border-black transition';
            }
            
            // Clear chord list
            document.getElementById('chordList').classList.add('hidden');
            document.getElementById('bulkActions').classList.add('hidden');
        }

        async function loadChordFamily(family) {
            try {
                const response = await fetch(`/fretbubble/presets?family=${family}&difficulty=${currentDifficulty}`);
                const chords = await response.json();
                currentChords = chords;
                
                const chordList = document.getElementById('chordList');
                const bulkActions = document.getElementById('bulkActions');
                
                chordList.innerHTML = '';
                chordList.classList.remove('hidden');
                bulkActions.classList.remove('hidden');
                
                chords.forEach(chord => {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'flex items-center gap-2 p-2 bg-white border-2 border-gray-300 rounded-md hover:border-blue-500 transition';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'chord-checkbox w-4 h-4 cursor-pointer';
                    checkbox.dataset.chordId = chord.id;
                    checkbox.onclick = (e) => {
                        e.stopPropagation();
                    };
                    checkbox.onchange = (e) => {
                        if (e.target.checked) {
                            selectedChords.push(chord.id);
                        } else {
                            const index = selectedChords.indexOf(chord.id);
                            if (index > -1) selectedChords.splice(index, 1);
                        }
                    };
                    
                    const btn = document.createElement('button');
                    btn.className = 'flex-1 text-left font-medium text-sm hover:text-blue-600 transition';
                    btn.textContent = chord.name;
                    btn.onclick = (e) => {
                        e.stopPropagation();
                        loadChordPreset(chord.id);
                    };
                    
                    wrapper.appendChild(checkbox);
                    wrapper.appendChild(btn);
                    chordList.appendChild(wrapper);
                });
            } catch (error) {
                console.error('Error loading chords:', error);
            }
        }



        async function loadChordPreset(chordId) {
            try {
                const response = await fetch(`/fretbubble/presets/${chordId}`);
                const chord = await response.json();
                
                // Update form
                document.getElementById('chordTitle').value = chord.name;
                document.getElementById('numFrets').value = chord.num_frets;
                document.getElementById('numStrings').value = chord.num_strings;
                document.getElementById('startingFret').value = chord.starting_fret;
                
                // Update state
                fingers = chord.fingers || [];
                openStrings = chord.open_strings || [];
                mutedStrings = chord.muted_strings || [];
                
                // Redraw
                initCanvases();
                
                // Auto close panel after loading chord
                toggleQuickChord();
            } catch (error) {
                console.error('Error loading preset:', error);
            }
        }

        function selectAllChords() {
            selectedChords = currentChords.map(c => c.id);
            document.querySelectorAll('.chord-checkbox').forEach(cb => {
                cb.checked = true;
            });
        }

        function deselectAllChords() {
            selectedChords = [];
            document.querySelectorAll('.chord-checkbox').forEach(cb => {
                cb.checked = false;
            });
        }

        async function bulkDownload() {
            if (selectedChords.length === 0) {
                alert('Pilih chord yang mau di-download!');
                return;
            }

            const zip = new JSZip();
            
            for (const chordId of selectedChords) {
                try {
                    const response = await fetch(`/fretbubble/presets/${chordId}`);
                    const chord = await response.json();
                    
                    // Create temporary canvas
                    const tempCanvas = document.createElement('canvas');
                    tempCanvas.width = 550;
                    tempCanvas.height = 650;
                    const tempCtx = tempCanvas.getContext('2d');
                    
                    // Set temporary state
                    const oldTitle = document.getElementById('chordTitle').value;
                    const oldFrets = document.getElementById('numFrets').value;
                    const oldStrings = document.getElementById('numStrings').value;
                    const oldStarting = document.getElementById('startingFret').value;
                    const oldFingers = [...fingers];
                    const oldOpen = [...openStrings];
                    const oldMuted = [...mutedStrings];
                    
                    document.getElementById('chordTitle').value = chord.name;
                    document.getElementById('numFrets').value = chord.num_frets;
                    document.getElementById('numStrings').value = chord.num_strings;
                    document.getElementById('startingFret').value = chord.starting_fret;
                    fingers = chord.fingers || [];
                    openStrings = chord.open_strings || [];
                    mutedStrings = chord.muted_strings || [];
                    
                    // Draw to temp canvas
                    drawFretboard(tempCtx, tempCanvas, false);
                    
                    // Get image data
                    const dataUrl = tempCanvas.toDataURL('image/png');
                    const base64Data = dataUrl.split(',')[1];
                    
                    // Add to zip
                    zip.file(`${chord.name}.png`, base64Data, {base64: true});
                    
                    // Restore state
                    document.getElementById('chordTitle').value = oldTitle;
                    document.getElementById('numFrets').value = oldFrets;
                    document.getElementById('numStrings').value = oldStrings;
                    document.getElementById('startingFret').value = oldStarting;
                    fingers = oldFingers;
                    openStrings = oldOpen;
                    mutedStrings = oldMuted;
                    
                } catch (error) {
                    console.error(`Error processing chord ${chordId}:`, error);
                }
            }
            
            // Generate and download zip
            const content = await zip.generateAsync({type: 'blob'});
            const link = document.createElement('a');
            link.href = URL.createObjectURL(content);
            link.download = 'chord_diagrams.zip';
            link.click();
            
            drawFretboard(editorCtx, editorCanvas, true);
            refreshPreview();
        }
    </script>
    
    <!-- About Modal -->
    <div id="aboutModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 opacity-0 pointer-events-none transition-all duration-300 p-4">
        <div id="aboutModalContent" class="bg-white border-4 border-black w-full max-w-2xl max-h-[90vh] overflow-y-auto transform scale-95 transition-all duration-300">
            <!-- Header -->
            <div class="bg-black text-white p-6 sm:p-8 flex items-center justify-between border-b-4 border-white">
                <h2 class="text-2xl sm:text-3xl font-bold">Om Swastiastu 🙏</h2>
                <button onclick="toggleAboutModal()" class="text-white hover:text-gray-300 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
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
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-4 text-gray-800 leading-relaxed mb-6">
                    <p class="text-base">
                        Saya adalah seorang <strong>web developer</strong> sekaligus <strong>music arranger</strong>. 
                        Dengan semangat kali ini, saya bertujuan untuk <strong>memperkanalkan karya-karya yang pernah saya buat</strong> 😊
                    </p>
                    <div class="bg-blue-50 border-l-4 border-blue-600 p-4">
                        <p class="font-semibold text-blue-900 mb-2">
                            Mari bersama-sama melestarikan bahasa dan budaya Bali melalui lagu Bali
                        </p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="space-y-3">
                    <a href="{{ route('home') }}" class="block w-full bg-black text-white py-3 sm:py-4 text-center font-bold hover:bg-gray-800 transition border-2 border-black">
                        LIHAT KARYA SAYA
                    </a>
                    <button onclick="toggleAboutModal(); toggleFeedbackModal();" class="block w-full bg-white text-black py-3 sm:py-4 text-center font-bold hover:bg-gray-100 transition border-2 border-black">
                        KIRIM PESAN
                    </button>
                    <a href="https://wa.me/6281805500" target="_blank" class="block w-full bg-green-600 text-white py-3 sm:py-4 text-center font-bold hover:bg-green-700 transition border-2 border-green-600">
                        💬 HUBUNGI WHATSAPP
                    </a>
                </div>
            </div>
        </div>
    </div>



    <!-- JSZip for bulk download -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
</x-layouts.app>
