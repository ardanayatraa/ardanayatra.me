<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test R2 Audio Upload</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6">🎵 Test R2 Audio Upload</h1>
        
        <form id="uploadForm" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Audio File (MP3, WAV, OGG, M4A - Max 50MB)
                </label>
                <input type="file" name="audio" id="audioFile" accept="audio/*" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div id="preview" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm font-medium text-blue-800 mb-2">📁 File selected:</p>
                <div class="bg-white p-3 rounded">
                    <p class="text-sm font-semibold" id="fileName"></p>
                    <p class="text-xs text-gray-600" id="fileSize"></p>
                </div>
            </div>
            
            <button type="submit" id="submitBtn"
                    class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400">
                <span id="submitText">🚀 Upload to R2</span>
                <span id="loadingText" class="hidden">⏳ Uploading...</span>
            </button>
        </form>
        
        <div id="result" class="mt-6 hidden"></div>
        
        <div id="player" class="mt-6 hidden">
            <h3 class="text-lg font-bold mb-3">🎧 Test Audio Player:</h3>
            <audio id="audioPlayer" controls class="w-full"></audio>
            <p class="text-xs text-gray-500 mt-2">
                ✅ If audio plays, R2 upload is working perfectly!
            </p>
        </div>
    </div>

    <script>
        const audioFile = document.getElementById('audioFile');
        const preview = document.getElementById('preview');
        const fileName = document.getElementById('fileName');
        const fileSize = document.getElementById('fileSize');
        const uploadForm = document.getElementById('uploadForm');
        const submitBtn = document.getElementById('submitBtn');
        const submitText = document.getElementById('submitText');
        const loadingText = document.getElementById('loadingText');
        const result = document.getElementById('result');
        const player = document.getElementById('player');
        const audioPlayer = document.getElementById('audioPlayer');

        // Preview file
        audioFile.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const file = this.files[0];
                const sizeMB = (file.size / 1024 / 1024).toFixed(2);
                
                fileName.textContent = file.name;
                fileSize.textContent = `Size: ${sizeMB} MB`;
                preview.classList.remove('hidden');
                
                if (file.size > 50 * 1024 * 1024) {
                    alert('File too large! Max 50MB');
                    this.value = '';
                    preview.classList.add('hidden');
                }
            }
        });

        // Upload form
        uploadForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            submitBtn.disabled = true;
            submitText.classList.add('hidden');
            loadingText.classList.remove('hidden');
            result.classList.add('hidden');
            player.classList.add('hidden');
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch('{{ route('test.r2.audio') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });
                
                const data = await response.json();
                
                if (response.ok && data.status === 'success') {
                    result.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <p class="text-green-800 font-bold mb-2">✅ ${data.message}</p>
                            <div class="text-sm text-green-700 space-y-1">
                                <p><strong>Path:</strong> ${data.path}</p>
                                <p><strong>Original:</strong> ${data.original_name}</p>
                                <p><strong>Upload Size:</strong> ${(data.file_size / 1024 / 1024).toFixed(2)} MB</p>
                                <p><strong>R2 Size:</strong> ${(data.r2_size / 1024 / 1024).toFixed(2)} MB</p>
                            </div>
                        </div>
                    `;
                    result.classList.remove('hidden');
                    
                    // Try to load audio player with public URL
                    const publicUrl = '{{ config('filesystems.disks.r2.url') }}/' + data.path;
                    audioPlayer.src = publicUrl;
                    player.classList.remove('hidden');
                } else {
                    let errorHtml = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <p class="text-red-800 font-bold mb-2">❌ Upload Gagal</p>
                            <p class="text-sm text-red-700 mb-2">${data.message || 'Unknown error'}</p>
                    `;
                    
                    if (data.help) {
                        errorHtml += `
                            <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                <p class="text-xs text-yellow-800 font-semibold mb-1">💡 Troubleshooting:</p>
                                <p class="text-xs text-yellow-700">${data.help}</p>
                            </div>
                        `;
                    }
                    
                    if (data.errors) {
                        errorHtml += `
                            <div class="mt-2 text-xs text-red-600">
                                <p class="font-semibold">Validation Errors:</p>
                                <ul class="list-disc list-inside">
                                    ${Object.values(data.errors).flat().map(err => `<li>${err}</li>`).join('')}
                                </ul>
                            </div>
                        `;
                    }
                    
                    errorHtml += `</div>`;
                    result.innerHTML = errorHtml;
                    result.classList.remove('hidden');
                }
            } catch (error) {
                console.error('Upload error:', error);
                result.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-red-800 font-bold mb-2">❌ Upload Failed</p>
                        <p class="text-sm text-red-700 mb-2">${error.message}</p>
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                            <p class="text-xs text-yellow-800 font-semibold mb-1">💡 Kemungkinan Penyebab:</p>
                            <ul class="text-xs text-yellow-700 list-disc list-inside space-y-1">
                                <li>Koneksi internet terputus</li>
                                <li>Kredensial R2 di .env tidak valid</li>
                                <li>File corrupt atau format tidak didukung</li>
                                <li>Server error - cek log Laravel</li>
                            </ul>
                        </div>
                    </div>
                `;
                result.classList.remove('hidden');
            } finally {
                submitBtn.disabled = false;
                submitText.classList.remove('hidden');
                loadingText.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
