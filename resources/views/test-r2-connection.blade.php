<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test R2 Connection</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8 mb-6">
            <h1 class="text-3xl font-bold mb-6">🔧 Test Cloudflare R2 Connection</h1>
            
            <div class="mb-6">
                <button onclick="testConnection()" id="testBtn"
                        class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    🚀 Test Connection
                </button>
            </div>
            
            <div id="loading" class="hidden mb-6">
                <div class="flex items-center gap-3 text-blue-600">
                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span>Testing R2 connection...</span>
                </div>
            </div>
            
            <div id="result"></div>
        </div>
        
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="font-bold text-blue-900 mb-3">📋 Checklist Setup R2:</h3>
            <ul class="space-y-2 text-sm text-blue-800">
                <li>✅ Bucket sudah dibuat di Cloudflare R2</li>
                <li>✅ Public Development URL sudah di-enable</li>
                <li>✅ API Token sudah dibuat (Object Read & Write)</li>
                <li>✅ Kredensial sudah diisi di .env</li>
                <li>✅ Config cache sudah di-clear: <code class="bg-blue-100 px-2 py-1 rounded">php artisan config:clear</code></li>
            </ul>
        </div>
    </div>

    <script>
        async function testConnection() {
            const testBtn = document.getElementById('testBtn');
            const loading = document.getElementById('loading');
            const result = document.getElementById('result');
            
            testBtn.disabled = true;
            loading.classList.remove('hidden');
            result.innerHTML = '';
            
            try {
                const response = await fetch('/test-r2');
                const data = await response.json();
                
                if (data.status === 'success') {
                    result.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                            <h3 class="text-xl font-bold text-green-800 mb-4">${data.message}</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold text-green-900 mb-2">📦 R2 Configuration:</h4>
                                    <div class="bg-white rounded p-3 text-sm space-y-1">
                                        <p><strong>Bucket:</strong> ${data.config.bucket}</p>
                                        <p><strong>Endpoint:</strong> ${data.config.endpoint}</p>
                                        <p><strong>Public URL:</strong> ${data.config.public_url}</p>
                                        <p><strong>Region:</strong> ${data.config.region}</p>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-semibold text-green-900 mb-2">✅ Test Results:</h4>
                                    <div class="bg-white rounded p-3 text-sm space-y-1">
                                        <p>✅ Write: ${data.test_results.write}</p>
                                        <p>✅ Read: ${data.test_results.read}</p>
                                        <p>✅ Exists: ${data.test_results.exists}</p>
                                        <p>✅ Delete: ${data.test_results.delete}</p>
                                    </div>
                                </div>
                                
                                <div class="bg-green-100 border border-green-300 rounded p-4">
                                    <p class="text-green-800 font-semibold">🎉 R2 siap digunakan!</p>
                                    <p class="text-sm text-green-700 mt-1">Sekarang kamu bisa upload file di <a href="/admin/songs/create" class="underline">Admin Songs</a></p>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    let helpHtml = '';
                    if (data.help && Array.isArray(data.help)) {
                        helpHtml = `
                            <div class="mt-4 bg-yellow-50 border border-yellow-200 rounded p-4">
                                <p class="font-semibold text-yellow-900 mb-2">💡 Troubleshooting:</p>
                                <ul class="text-sm text-yellow-800 space-y-1 list-disc list-inside">
                                    ${data.help.map(h => `<li>${h}</li>`).join('')}
                                </ul>
                            </div>
                        `;
                    }
                    
                    result.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                            <h3 class="text-xl font-bold text-red-800 mb-4">❌ Connection Failed</h3>
                            <p class="text-red-700 mb-4">${data.message}</p>
                            
                            ${data.config ? `
                                <div class="mb-4">
                                    <h4 class="font-semibold text-red-900 mb-2">Current Config:</h4>
                                    <pre class="bg-white rounded p-3 text-xs overflow-auto">${JSON.stringify(data.config, null, 2)}</pre>
                                </div>
                            ` : ''}
                            
                            ${helpHtml}
                        </div>
                    `;
                }
            } catch (error) {
                result.innerHTML = `
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <h3 class="text-xl font-bold text-red-800 mb-4">❌ Request Failed</h3>
                        <p class="text-red-700">${error.message}</p>
                    </div>
                `;
            } finally {
                testBtn.disabled = false;
                loading.classList.add('hidden');
            }
        }
    </script>
</body>
</html>
