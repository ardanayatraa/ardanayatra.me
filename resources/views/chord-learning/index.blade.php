<x-layouts.app>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }
        .chord-card {
            transition: all 0.3s ease;
        }
        .chord-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }
        .chord-card.active {
            border-color: #000;
            box-shadow: 0 0 0 3px rgba(0,0,0,0.1);
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-4xl sm:text-5xl font-bold text-gray-900 mb-3">Belajar Chord Gitar</h1>
            </div>

            <!-- Legend -->
            <div class="bg-white border-2 border-black p-6 mb-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Panduan Membaca Diagram:</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 border-2 border-black">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" fill="none" stroke="black" stroke-width="2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">O = Open String</p>
                            <p class="text-xs text-gray-600">Senar dimainkan tanpa ditekan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 border-2 border-black">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <text x="12" y="18" text-anchor="middle" font-size="20" font-weight="bold" fill="black">×</text>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">X = Muted</p>
                            <p class="text-xs text-gray-600">Senar tidak dimainkan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center w-12 h-12 border-2 border-black">
                            <svg width="24" height="24" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="8" fill="black"/>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">● = Finger Position</p>
                            <p class="text-xs text-gray-600">Posisi jari menekan senar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter -->
            <div class="bg-white border-2 border-black p-4 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button onclick="filterChords('all')" 
                        class="filter-btn px-4 py-2 text-sm font-medium border-2 border-black bg-black text-white">
                        Semua
                    </button>
                    @foreach($families as $family)
                        <button onclick="filterChords('{{ $family }}')" 
                            class="filter-btn px-4 py-2 text-sm font-medium border-2 border-black bg-white text-black hover:bg-black hover:text-white transition">
                            {{ $family }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Chord Grid -->
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 mb-8" id="chordGrid">
                @foreach($chords as $chord)
                    <div class="chord-card bg-white border-2 border-gray-300 p-4 cursor-pointer" 
                         data-family="{{ $chord->family }}"
                         onclick="showChord({{ $chord->id }})">
                        <canvas id="chord-{{ $chord->id }}" class="w-full mb-2"></canvas>
                        <p class="text-center font-bold text-gray-900">{{ $chord->name }}</p>
                        <p class="text-center text-xs text-gray-500">{{ ucfirst($chord->type) }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Detail Modal -->
            <div id="chordModal" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black bg-opacity-50">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl border-2 border-black">
                    <div class="flex items-center justify-between p-6 border-b-2 border-black">
                        <h2 class="text-2xl font-bold" id="modalTitle">Chord Detail</h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6">
                        <div class="flex justify-center mb-6">
                            <canvas id="modalCanvas" class="border-2 border-black"></canvas>
                        </div>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="font-semibold text-gray-700">Family:</p>
                                <p id="modalFamily" class="text-gray-900"></p>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-700">Type:</p>
                                <p id="modalType" class="text-gray-900"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const chords = @json($chords);
        let currentChord = null;

        // Draw small chord diagrams
        function drawSmallChord(chord) {
            const canvas = document.getElementById(`chord-${chord.id}`);
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            const size = canvas.parentElement.clientWidth;
            canvas.width = size;
            canvas.height = size * 1.4;
            
            const padding = 15;
            const width = canvas.width - (padding * 2);
            const height = canvas.height - (padding * 2) - 30;
            const stringSpacing = width / (chord.num_strings - 1);
            const fretSpacing = height / chord.num_frets;

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Strings
            ctx.strokeStyle = '#000000';
            for (let i = 0; i < chord.num_strings; i++) {
                const x = padding + (i * stringSpacing);
                ctx.lineWidth = 1 + (i * 0.1);
                ctx.beginPath();
                ctx.moveTo(x, padding + 20);
                ctx.lineTo(x, padding + 20 + height);
                ctx.stroke();
            }

            // Frets
            for (let i = 0; i <= chord.num_frets; i++) {
                const y = padding + 20 + (i * fretSpacing);
                ctx.lineWidth = i === 0 && chord.starting_fret === 0 ? 4 : 1.5;
                ctx.beginPath();
                ctx.moveTo(padding, y);
                ctx.lineTo(padding + width, y);
                ctx.stroke();
            }

            // Open/Muted
            ctx.font = 'bold 12px Inter';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            for (let i = 0; i < chord.num_strings; i++) {
                const x = padding + (i * stringSpacing);
                const y = padding + 10;
                
                const hasFinger = chord.fingers.some(f => f.string === i);
                const isMuted = chord.muted_strings?.includes(i);
                
                if (isMuted) {
                    ctx.fillStyle = '#000000';
                    ctx.fillText('×', x, y);
                } else if (!hasFinger) {
                    ctx.strokeStyle = '#000000';
                    ctx.lineWidth = 2;
                    ctx.beginPath();
                    ctx.arc(x, y, 6, 0, Math.PI * 2);
                    ctx.stroke();
                }
            }

            // Fingers
            ctx.fillStyle = '#000000';
            chord.fingers.forEach(finger => {
                const x = padding + (finger.string * stringSpacing);
                const y = padding + 20 + (finger.fret * fretSpacing) - (fretSpacing / 2);
                ctx.beginPath();
                ctx.arc(x, y, 8, 0, Math.PI * 2);
                ctx.fill();
            });
        }

        // Draw large chord in modal
        function drawLargeChord(chord) {
            const canvas = document.getElementById('modalCanvas');
            const ctx = canvas.getContext('2d');
            
            canvas.width = 400;
            canvas.height = 550;
            
            const paddingTop = 80;
            const paddingBottom = 40;
            const paddingSide = 60;
            const width = canvas.width - (paddingSide * 2);
            const height = canvas.height - paddingTop - paddingBottom;
            const stringSpacing = width / (chord.num_strings - 1);
            const fretSpacing = height / chord.num_frets;

            ctx.fillStyle = '#ffffff';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Title
            ctx.font = 'bold 32px Poppins';
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'center';
            ctx.fillText(chord.name, canvas.width / 2, 40);

            // Strings
            ctx.strokeStyle = '#000000';
            for (let i = 0; i < chord.num_strings; i++) {
                const x = paddingSide + (i * stringSpacing);
                ctx.lineWidth = 1.5 + (i * 0.2);
                ctx.beginPath();
                ctx.moveTo(x, paddingTop);
                ctx.lineTo(x, paddingTop + height);
                ctx.stroke();
            }

            // Frets
            for (let i = 0; i <= chord.num_frets; i++) {
                const y = paddingTop + (i * fretSpacing);
                ctx.lineWidth = i === 0 && chord.starting_fret === 0 ? 6 : 2;
                ctx.beginPath();
                ctx.moveTo(paddingSide, y);
                ctx.lineTo(paddingSide + width, y);
                ctx.stroke();
            }

            // Open/Muted
            ctx.font = 'bold 20px Inter';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            for (let i = 0; i < chord.num_strings; i++) {
                const x = paddingSide + (i * stringSpacing);
                const y = paddingTop - 15;
                
                const hasFinger = chord.fingers.some(f => f.string === i);
                const isMuted = chord.muted_strings?.includes(i);
                
                if (isMuted) {
                    ctx.fillStyle = '#000000';
                    ctx.fillText('×', x, y);
                } else if (!hasFinger) {
                    ctx.strokeStyle = '#000000';
                    ctx.lineWidth = 3;
                    ctx.beginPath();
                    ctx.arc(x, y, 12, 0, Math.PI * 2);
                    ctx.stroke();
                }
            }

            // Fingers
            ctx.fillStyle = '#000000';
            chord.fingers.forEach(finger => {
                const x = paddingSide + (finger.string * stringSpacing);
                const y = paddingTop + (finger.fret * fretSpacing) - (fretSpacing / 2);
                ctx.beginPath();
                ctx.arc(x, y, 16, 0, Math.PI * 2);
                ctx.fill();
            });

            // String numbers
            ctx.font = 'bold 14px Inter';
            ctx.fillStyle = '#000000';
            ctx.textAlign = 'center';
            for (let i = 0; i < chord.num_strings; i++) {
                const x = paddingSide + (i * stringSpacing);
                const y = paddingTop + height + 25;
                ctx.fillText((chord.num_strings - i).toString(), x, y);
            }
        }

        // Show chord detail
        function showChord(id) {
            const chord = chords.find(c => c.id === id);
            if (!chord) return;
            
            currentChord = chord;
            document.getElementById('modalTitle').textContent = chord.name;
            document.getElementById('modalFamily').textContent = chord.family;
            document.getElementById('modalType').textContent = chord.type.charAt(0).toUpperCase() + chord.type.slice(1);
            
            drawLargeChord(chord);
            document.getElementById('chordModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Highlight active card
            document.querySelectorAll('.chord-card').forEach(card => card.classList.remove('active'));
            event.target.closest('.chord-card').classList.add('active');
        }

        function closeModal() {
            document.getElementById('chordModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            document.querySelectorAll('.chord-card').forEach(card => card.classList.remove('active'));
        }

        // Filter chords
        function filterChords(family) {
            const cards = document.querySelectorAll('.chord-card');
            const buttons = document.querySelectorAll('.filter-btn');
            
            // Update button styles
            buttons.forEach(btn => {
                btn.className = 'filter-btn px-4 py-2 text-sm font-medium border-2 border-black bg-white text-black hover:bg-black hover:text-white transition';
            });
            event.target.className = 'filter-btn px-4 py-2 text-sm font-medium border-2 border-black bg-black text-white';
            
            // Filter cards
            cards.forEach(card => {
                if (family === 'all' || card.dataset.family === family) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Initialize
        window.addEventListener('load', () => {
            chords.forEach(chord => drawSmallChord(chord));
        });

        window.addEventListener('resize', () => {
            chords.forEach(chord => drawSmallChord(chord));
        });
    </script>
</x-layouts.app>
