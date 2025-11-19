<x-layouts.app>
    <div class="min-h-screen bg-gray-50 py-12 px-4">
        <div class="container mx-auto max-w-5xl">
            <div class="text-center mb-12">
                <h1 class="text-5xl font-bold text-black mb-3">InvoiceGo</h1>
                <p class="text-gray-600 text-lg">Buat invoice profesional dalam hitungan detik</p>
            </div>

            <form action="{{ route('invoicego.generate') }}" method="POST" class="bg-white shadow-xl rounded-2xl px-10 pt-8 pb-10 mb-4 border border-gray-200">
            @csrf

            <!-- Company Information Section -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-black mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informasi Perusahaan
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company_name">
                            Nama Perusahaan *
                        </label>
                        <input type="text" name="company_name" id="company_name" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('company_name') }}" required>
                        @error('company_name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company_email">
                            Email Perusahaan *
                        </label>
                        <input type="email" name="company_email" id="company_email" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('company_email') }}" required>
                        @error('company_email')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company_phone">
                            Telepon Perusahaan
                        </label>
                        <input type="text" name="company_phone" id="company_phone" placeholder="+62"
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('company_phone') }}">
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company_website">
                            Website Perusahaan
                        </label>
                        <input type="text" name="company_website" id="company_website" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('company_website') }}">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="company_address">
                            Alamat Perusahaan *
                        </label>
                        <textarea name="company_address" id="company_address" rows="2"
                                  class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition" required>{{ old('company_address') }}</textarea>
                        @error('company_address')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Invoice Details Section -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-black mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Detail Invoice
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="invoice_number">
                            Nomor Invoice *
                        </label>
                        <input type="text" name="invoice_number" id="invoice_number" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('invoice_number', 'INV-' . date('Ymd') . '-001') }}" required>
                        @error('invoice_number')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="invoice_date">
                            Tanggal Invoice *
                        </label>
                        <input type="date" name="invoice_date" id="invoice_date" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                        @error('invoice_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="due_date">
                            Jatuh Tempo *
                        </label>
                        <input type="date" name="due_date" id="due_date" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                        @error('due_date')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Client Information Section -->
            <div class="mb-8 pb-8 border-b border-gray-200">
                <h2 class="text-2xl font-bold text-black mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Klien
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="client_name">
                            Nama Klien *
                        </label>
                        <input type="text" name="client_name" id="client_name" 
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('client_name') }}" required>
                        @error('client_name')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="client_phone">
                            No. HP Klien *
                        </label>
                        <input type="text" name="client_phone" id="client_phone" placeholder="+62"
                               class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition"
                               value="{{ old('client_phone') }}" required>
                        @error('client_phone')
                            <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="client_address">
                            Alamat Klien
                        </label>
                        <textarea name="client_address" id="client_address" rows="2"
                                  class="border border-gray-300 text-gray-900 rounded-lg w-full py-3 px-4 focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent transition">{{ old('client_address') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Invoice Items Section -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-black mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Item Invoice
                </h2>
                
                <div class="bg-gray-50 rounded-lg p-4 mb-4 border border-gray-200">
                    <div class="grid grid-cols-12 gap-3 mb-3 text-gray-700 text-sm font-bold">
                        <div class="col-span-5">Deskripsi</div>
                        <div class="col-span-2 text-center">Jumlah</div>
                        <div class="col-span-3 text-right">Harga</div>
                        <div class="col-span-2 text-right">Total</div>
                    </div>

                    <div id="items-container">
                        <div class="item-row grid grid-cols-12 gap-3 mb-3">
                            <div class="col-span-5">
                                <input type="text" name="items[0][description]" placeholder="Deskripsi item" 
                                       class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-black transition" required>
                            </div>
                            <div class="col-span-2">
                                <input type="number" name="items[0][quantity]" placeholder="1" min="1" value="1"
                                       class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 text-center focus:outline-none focus:ring-2 focus:ring-black transition item-quantity" required>
                            </div>
                            <div class="col-span-3">
                                <input type="number" name="items[0][price]" placeholder="0" min="0" step="1000"
                                       class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 text-right focus:outline-none focus:ring-2 focus:ring-black transition item-price" required>
                            </div>
                            <div class="col-span-2 flex items-center justify-end">
                                <span class="item-total font-bold text-gray-900">0</span>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" id="add-item" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Item
                </button>
            </div>

            <!-- Total Section -->
            <div class="mt-8 bg-black rounded-lg p-6">
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-white">Total Keseluruhan:</span>
                    <span class="text-4xl font-bold text-white">Rp <span id="grand-total">0</span></span>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-center">
                <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-4 px-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-black transition shadow-lg text-lg">
                    <svg class="w-6 h-6 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Buat Invoice
                </button>
            </div>
        </form>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        document.getElementById('add-item').addEventListener('click', function() {
            const container = document.getElementById('items-container');
            const newRow = document.createElement('div');
            newRow.className = 'item-row grid grid-cols-12 gap-3 mb-3';
            newRow.innerHTML = `
                <div class="col-span-5">
                    <input type="text" name="items[${itemIndex}][description]" placeholder="Deskripsi item" 
                           class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-black transition" required>
                </div>
                <div class="col-span-2">
                    <input type="number" name="items[${itemIndex}][quantity]" placeholder="1" min="1" value="1"
                           class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 text-center focus:outline-none focus:ring-2 focus:ring-black transition item-quantity" required>
                </div>
                <div class="col-span-3">
                    <input type="number" name="items[${itemIndex}][price]" placeholder="0" min="0" step="1000"
                           class="bg-white border border-gray-300 text-gray-900 rounded-lg w-full py-2 px-3 text-right focus:outline-none focus:ring-2 focus:ring-black transition item-price" required>
                </div>
                <div class="col-span-2 flex items-center justify-between">
                    <span class="item-total font-bold text-gray-900">0</span>
                    <button type="button" class="remove-item text-red-500 hover:text-red-700 font-bold text-2xl transition">×</button>
                </div>
            `;
            container.appendChild(newRow);
            itemIndex++;
            attachItemListeners(newRow);
        });

        function attachItemListeners(row) {
            const quantity = row.querySelector('.item-quantity');
            const price = row.querySelector('.item-price');
            const total = row.querySelector('.item-total');
            const removeBtn = row.querySelector('.remove-item');

            function updateTotal() {
                const qty = parseFloat(quantity.value) || 0;
                const prc = parseFloat(price.value) || 0;
                total.textContent = Math.round(qty * prc).toLocaleString('id-ID');
                updateGrandTotal();
            }

            quantity.addEventListener('input', updateTotal);
            price.addEventListener('input', updateTotal);

            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    row.remove();
                    updateGrandTotal();
                });
            }
        }

        function updateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.item-total').forEach(function(el) {
                const value = el.textContent.replace(/\./g, '').replace(/,/g, '');
                total += parseFloat(value) || 0;
            });
            document.getElementById('grand-total').textContent = Math.round(total).toLocaleString('id-ID');
        }

        document.querySelectorAll('.item-row').forEach(attachItemListeners);
    </script>
</x-layouts.app>
