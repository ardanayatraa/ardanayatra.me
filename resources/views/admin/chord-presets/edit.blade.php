<x-layouts.admin>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Form Column -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-6">
                            <h2 class="text-2xl font-bold text-gray-900">Edit: {{ $chordPreset->name }}</h2>
                            <a href="{{ route('admin.chord-presets.index') }}" 
                               class="text-gray-600 hover:text-gray-900">
                                ← Back
                            </a>
                        </div>

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.chord-presets.update', $chordPreset) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Chord Name</label>
                                <input type="text" name="name" value="{{ old('name', $chordPreset->name) }}" required
                                       class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                                <p class="text-xs text-gray-500 mt-1">e.g., C, Am, G7</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Family</label>
                                <input type="text" name="family" value="{{ old('family', $chordPreset->family) }}" required
                                       class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                                <p class="text-xs text-gray-500 mt-1">e.g., C, A, G</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                                <select name="type" required class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                                    <option value="major" {{ $chordPreset->type == 'major' ? 'selected' : '' }}>Major</option>
                                    <option value="minor" {{ $chordPreset->type == 'minor' ? 'selected' : '' }}>Minor</option>
                                    <option value="7" {{ $chordPreset->type == '7' ? 'selected' : '' }}>7th</option>
                                    <option value="maj7" {{ $chordPreset->type == 'maj7' ? 'selected' : '' }}>Major 7th</option>
                                    <option value="m7" {{ $chordPreset->type == 'm7' ? 'selected' : '' }}>Minor 7th</option>
                                    <option value="sus2" {{ $chordPreset->type == 'sus2' ? 'selected' : '' }}>Sus2</option>
                                    <option value="sus4" {{ $chordPreset->type == 'sus4' ? 'selected' : '' }}>Sus4</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                                <select name="difficulty" required class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                                    <option value="simple" {{ $chordPreset->difficulty == 'simple' ? 'selected' : '' }}>Simple</option>
                                    <option value="advanced" {{ $chordPreset->difficulty == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Starting Fret</label>
                                <input type="number" name="starting_fret" value="{{ old('starting_fret', $chordPreset->starting_fret) }}" min="0" required
                                       class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Number of Frets</label>
                                <input type="number" name="num_frets" value="{{ old('num_frets', $chordPreset->num_frets) }}" min="3" max="12" required
                                       class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Number of Strings</label>
                                <input type="number" name="num_strings" value="{{ old('num_strings', $chordPreset->num_strings) }}" min="4" max="8" required
                                       class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Fingers (JSON)</label>
                            <textarea name="fingers" rows="4" required
                                      class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0 font-mono text-sm">{{ old('fingers', json_encode($chordPreset->fingers)) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: [{"string":0,"fret":1}, {"string":1,"fret":2}]</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Open Strings (JSON)</label>
                            <textarea name="open_strings" rows="2"
                                      class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0 font-mono text-sm">{{ old('open_strings', json_encode($chordPreset->open_strings ?? [])) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: [0, 3, 4] (string indices)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Muted Strings (JSON)</label>
                            <textarea name="muted_strings" rows="2"
                                      class="w-full border-2 border-gray-300 rounded px-3 py-2 focus:border-black focus:ring-0 font-mono text-sm">{{ old('muted_strings', json_encode($chordPreset->muted_strings ?? [])) }}</textarea>
                            <p class="text-xs text-gray-500 mt-1">Format: [5] (string indices)</p>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" 
                                    class="bg-black text-white px-6 py-2 rounded hover:bg-gray-800 transition">
                                Update Chord Preset
                            </button>
                            <a href="{{ route('admin.chord-presets.index') }}" 
                               class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400 transition">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Editor Column -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:sticky lg:top-6 lg:self-start">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Interactive Editor</h3>
                    <div class="border-2 border-black p-4 bg-white mb-4">
                        <canvas id="editorCanvas" class="w-full cursor-pointer"></canvas>
                    </div>
                    <div class="flex gap-2 mb-2">
                        <button type="button" onclick="clearFingers()" 
                            class="flex-1 px-3 py-2 text-sm font-medium text-black bg-white border-2 border-black hover:bg-black hover:text-white transition">
                            Reset
                        </button>
                        <button type="button" onclick="toggleMute()" id="muteBtn"
                            class="flex-1 px-3 py-2 text-sm font-medium text-black bg-white border-2 border-black hover:bg-black hover:text-white transition">
                            Toggle Mute (X)
                        </button>
                    </div>
                    <p class="text-xs text-gray-500">Click fretboard to add/remove fingers. Click above nut for open strings (O).</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const editorCanvas = document.getElementById('editorCanvas');
    const ctx = editorCanvas.getContext('2d');
    
    let chordData = {
        name: '{{ $chordPreset->name }}',
        fingers: @json($chordPreset->fingers ?? []),
        openStrings: @json($chordPreset->open_strings ?? []),
        mutedStrings: @json($chordPreset->muted_strings ?? []),
        numFrets: {{ $chordPreset->num_frets }},
        numStrings: {{ $chordPreset->num_strings }},
        startingFret: {{ $chordPreset->starting_fret }}
    };

    let muteMode = false;

    function drawEditor() {
        const containerWidth = Math.min(editorCanvas.parentElement.clientWidth, 550);
        editorCanvas.width = containerWidth;
        editorCanvas.height = containerWidth * 1.18;
        
        const paddingTop = 100;
        const paddingBottom = 60;
        const paddingSide = 80;
        const width = editorCanvas.width - (paddingSide * 2);
        const height = editorCanvas.height - paddingTop - paddingBottom;
        const stringSpacing = width / (chordData.numStrings - 1);
        const fretSpacing = height / chordData.numFrets;

        // Clear
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, editorCanvas.width, editorCanvas.height);

        // Title
        const titleSize = Math.max(24, Math.min(32, editorCanvas.width / 17));
        ctx.font = `bold ${titleSize}px 'Poppins', sans-serif`;
        ctx.fillStyle = '#000000';
        ctx.textAlign = 'center';
        ctx.fillText(chordData.name, editorCanvas.width / 2, titleSize + 13);

        // Strings
        ctx.strokeStyle = '#000000';
        for (let i = 0; i < chordData.numStrings; i++) {
            const x = paddingSide + (i * stringSpacing);
            ctx.lineWidth = 1.5 + (i * 0.2);
            ctx.beginPath();
            ctx.moveTo(x, paddingTop);
            ctx.lineTo(x, paddingTop + height);
            ctx.stroke();
        }

        // Frets
        for (let i = 0; i <= chordData.numFrets; i++) {
            const y = paddingTop + (i * fretSpacing);
            ctx.lineWidth = i === 0 && chordData.startingFret === 0 ? 6 : 2;
            ctx.beginPath();
            ctx.moveTo(paddingSide, y);
            ctx.lineTo(paddingSide + width, y);
            ctx.stroke();
        }

        // Open/Muted strings - positioned right above the nut
        const symbolSize = Math.max(18, Math.min(24, editorCanvas.width / 25));
        ctx.font = `bold ${symbolSize}px 'Inter', sans-serif`;
        ctx.textAlign = 'center';
        ctx.textBaseline = 'middle';
        for (let i = 0; i < chordData.numStrings; i++) {
            const x = paddingSide + (i * stringSpacing);
            const y = paddingTop - 20; // Closer to nut
            
            const hasFinger = chordData.fingers.some(f => f.string === i);
            const isMuted = chordData.mutedStrings.includes(i);
            const isExplicitOpen = chordData.openStrings.includes(i);
            
            if (isMuted) {
                // Show X for muted strings
                ctx.fillStyle = '#000000';
                ctx.fillText('×', x, y);
            } else if (!hasFinger || isExplicitOpen) {
                // Show O for strings without fingers (default open) or explicitly marked open
                ctx.strokeStyle = '#000000';
                ctx.lineWidth = 3;
                ctx.beginPath();
                ctx.arc(x, y, 14, 0, Math.PI * 2);
                ctx.stroke();
            }
        }

        // Fingers
        ctx.fillStyle = '#000000';
        chordData.fingers.forEach(finger => {
            const x = paddingSide + (finger.string * stringSpacing);
            const y = paddingTop + (finger.fret * fretSpacing) - (fretSpacing / 2);
            ctx.beginPath();
            ctx.arc(x, y, 18, 0, Math.PI * 2);
            ctx.fill();
        });

        // Fret numbers
        const fretNumSize = Math.max(11, Math.min(14, editorCanvas.width / 40));
        ctx.font = `bold ${fretNumSize}px 'Inter', sans-serif`;
        ctx.textAlign = 'right';
        for (let i = 1; i <= chordData.numFrets; i++) {
            const y = paddingTop + (i * fretSpacing) - (fretSpacing / 2);
            const fretNum = chordData.startingFret + i;
            const textX = paddingSide - 25;
            const textY = y + 5;
            
            const textWidth = ctx.measureText(fretNum.toString()).width;
            ctx.fillStyle = '#ffffff';
            ctx.fillRect(textX - textWidth - 4, textY - fretNumSize, textWidth + 8, fretNumSize + 4);
            
            ctx.fillStyle = '#000000';
            ctx.fillText(fretNum.toString(), textX, textY);
        }

        // Starting fret label
        if (chordData.startingFret > 0) {
            const labelSize = Math.max(16, Math.min(20, editorCanvas.width / 27));
            ctx.font = `bold ${labelSize}px 'Poppins', sans-serif`;
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'left';
            const labelY = paddingTop + (fretSpacing / 2);
            ctx.fillText(chordData.startingFret + 'fr', paddingSide + width + 20, labelY + 5);
        }

        // String numbers
        const stringNumSize = Math.max(12, Math.min(16, editorCanvas.width / 35));
        ctx.font = `bold ${stringNumSize}px 'Inter', sans-serif`;
        ctx.fillStyle = '#000000';
        ctx.textAlign = 'center';
        for (let i = 0; i < chordData.numStrings; i++) {
            const x = paddingSide + (i * stringSpacing);
            const y = paddingTop + height + 35;
            ctx.fillText((chordData.numStrings - i).toString(), x, y);
        }
    }

    // Update JSON fields
    function updateJSON() {
        document.querySelector('textarea[name="fingers"]').value = JSON.stringify(chordData.fingers);
        document.querySelector('textarea[name="open_strings"]').value = JSON.stringify(chordData.openStrings);
        document.querySelector('textarea[name="muted_strings"]').value = JSON.stringify(chordData.mutedStrings);
    }

    // Canvas click handler
    editorCanvas.addEventListener('click', (e) => {
        const rect = editorCanvas.getBoundingClientRect();
        // Get actual canvas coordinates
        const scaleX = editorCanvas.width / rect.width;
        const scaleY = editorCanvas.height / rect.height;
        const canvasX = (e.clientX - rect.left) * scaleX;
        const canvasY = (e.clientY - rect.top) * scaleY;
        
        const paddingTop = 100;
        const paddingBottom = 60;
        const paddingSide = 80;
        const width = editorCanvas.width - (paddingSide * 2);
        const height = editorCanvas.height - paddingTop - paddingBottom;
        const stringSpacing = width / (chordData.numStrings - 1);
        const fretSpacing = height / chordData.numFrets;

        // Check if click is above nut (open string area) - expanded area
        if (canvasY < paddingTop && canvasY > 20) {
            const stringIndex = Math.round((canvasX - paddingSide) / stringSpacing);
            if (stringIndex >= 0 && stringIndex < chordData.numStrings) {
                if (muteMode) {
                    toggleMutedString(stringIndex);
                } else {
                    toggleOpenString(stringIndex);
                }
                drawEditor();
                updateJSON();
                return;
            }
        }

        // Check if click is within fretboard area
        if (canvasY < paddingTop || canvasY > paddingTop + height) {
            return; // Click outside fretboard
        }

        // Find closest string
        const stringIndex = Math.round((canvasX - paddingSide) / stringSpacing);
        if (stringIndex < 0 || stringIndex >= chordData.numStrings) {
            return; // Click outside string range
        }

        // Find which fret was clicked (between frets, not on fret lines)
        const relativeY = canvasY - paddingTop;
        const fretIndex = Math.ceil(relativeY / fretSpacing);

        if (fretIndex > 0 && fretIndex <= chordData.numFrets) {
            toggleFinger(stringIndex, fretIndex);
            drawEditor();
            updateJSON();
        }
    });

    function toggleFinger(string, fret) {
        const index = chordData.fingers.findIndex(f => f.string === string && f.fret === fret);
        if (index > -1) {
            chordData.fingers.splice(index, 1);
        } else {
            chordData.fingers = chordData.fingers.filter(f => f.string !== string);
            chordData.fingers.push({ string, fret });
            chordData.openStrings = chordData.openStrings.filter(s => s !== string);
            chordData.mutedStrings = chordData.mutedStrings.filter(s => s !== string);
        }
    }

    function toggleOpenString(string) {
        // Simple toggle: O (default/open) <-> X (muted)
        const hasFinger = chordData.fingers.some(f => f.string === string);
        const isMuted = chordData.mutedStrings.includes(string);
        
        if (hasFinger) {
            // If has finger, remove finger (will become O automatically)
            chordData.fingers = chordData.fingers.filter(f => f.string !== string);
        } else if (isMuted) {
            // If muted (X), change back to open (O)
            chordData.mutedStrings = chordData.mutedStrings.filter(s => s !== string);
        } else {
            // If open (O), change to muted (X)
            chordData.mutedStrings.push(string);
        }
        
        // Clean up openStrings array (not needed since we show O by default)
        chordData.openStrings = chordData.openStrings.filter(s => s !== string);
    }

    function toggleMutedString(string) {
        // In mute mode, directly toggle muted
        const index = chordData.mutedStrings.indexOf(string);
        if (index > -1) {
            chordData.mutedStrings.splice(index, 1);
        } else {
            chordData.mutedStrings.push(string);
            chordData.openStrings = chordData.openStrings.filter(s => s !== string);
            chordData.fingers = chordData.fingers.filter(f => f.string !== string);
        }
    }

    function clearFingers() {
        chordData.fingers = [];
        chordData.openStrings = [];
        chordData.mutedStrings = [];
        drawEditor();
        updateJSON();
    }

    function toggleMute() {
        muteMode = !muteMode;
        const btn = document.getElementById('muteBtn');
        if (muteMode) {
            btn.className = 'flex-1 px-3 py-2 text-sm font-medium text-white bg-black border-2 border-black transition';
            btn.textContent = 'Mute Mode: ON';
        } else {
            btn.className = 'flex-1 px-3 py-2 text-sm font-medium text-black bg-white border-2 border-black hover:bg-black hover:text-white transition';
            btn.textContent = 'Toggle Mute (X)';
        }
    }

    // Update editor when form fields change
    document.querySelector('textarea[name="fingers"]').addEventListener('input', function() {
        try {
            chordData.fingers = JSON.parse(this.value);
            drawEditor();
        } catch(e) {}
    });

    document.querySelector('textarea[name="open_strings"]').addEventListener('input', function() {
        try {
            chordData.openStrings = JSON.parse(this.value);
            drawEditor();
        } catch(e) {}
    });

    document.querySelector('textarea[name="muted_strings"]').addEventListener('input', function() {
        try {
            chordData.mutedStrings = JSON.parse(this.value);
            drawEditor();
        } catch(e) {}
    });

    document.querySelector('input[name="name"]').addEventListener('input', function() {
        chordData.name = this.value;
        drawEditor();
    });

    document.querySelector('input[name="num_frets"]').addEventListener('change', function() {
        chordData.numFrets = parseInt(this.value);
        drawEditor();
    });

    document.querySelector('input[name="num_strings"]').addEventListener('change', function() {
        chordData.numStrings = parseInt(this.value);
        drawEditor();
    });

    document.querySelector('input[name="starting_fret"]').addEventListener('change', function() {
        chordData.startingFret = parseInt(this.value);
        drawEditor();
    });

    // Initial draw
    drawEditor();
    window.addEventListener('resize', drawEditor);
</script>
</x-layouts.admin>
