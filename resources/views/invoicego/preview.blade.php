<x-layouts.app>
    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-black py-12 px-4">
        <div class="container mx-auto max-w-5xl">
            <!-- Action Buttons -->
            <div class="mb-8 flex justify-between items-center">
                <a href="{{ route('invoicego.index') }}" class="bg-white hover:bg-gray-200 text-black font-bold py-3 px-6 rounded-lg transition transform hover:scale-105 flex items-center border-2 border-black">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <form action="{{ route('invoicego.generate') }}" method="POST" class="inline">
                    @csrf
                    @foreach($invoice as $key => $value)
                        @if(is_array($value))
                            @foreach($value as $index => $item)
                                @foreach($item as $itemKey => $itemValue)
                                    <input type="hidden" name="{{ $key }}[{{ $index }}][{{ $itemKey }}]" value="{{ $itemValue }}">
                                @endforeach
                            @endforeach
                        @else
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <input type="hidden" name="download" value="1">
                    <button type="submit" class="bg-black hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg transition transform hover:scale-105 flex items-center border-2 border-white">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Unduh PDF
                    </button>
                </form>
            </div>

            <!-- Invoice Preview -->
            <div id="invoice" class="bg-white shadow-2xl rounded-2xl p-12 max-w-4xl mx-auto">
                <!-- Header -->
                <div class="border-b-4 border-black pb-8 mb-8">
                    <h1 class="text-6xl font-bold text-black mb-4 tracking-wider">INVOICE</h1>
                    <div class="text-gray-700 text-right">
                        <p class="text-sm"><strong>No. Invoice:</strong> {{ $invoice['invoice_number'] }}</p>
                        <p class="text-sm"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice['invoice_date'])->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                        <p class="text-sm"><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice['due_date'])->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                    </div>
                </div>

                <!-- Parties -->
                <div class="grid grid-cols-2 gap-12 mb-12">
                    <div>
                        <h2 class="text-sm font-bold text-black mb-3 uppercase tracking-wider">Dari</h2>
                        <div class="text-gray-700 text-sm">
                            <p class="font-bold text-base mb-2">{{ $invoice['company_name'] }}</p>
                            <p class="whitespace-pre-line">{{ $invoice['company_address'] }}</p>
                            @if(!empty($invoice['company_phone']))
                                <p class="mt-1">Telepon: {{ $invoice['company_phone'] }}</p>
                            @endif
                            <p>Email: {{ $invoice['company_email'] }}</p>
                            @if(!empty($invoice['company_website']))
                                <p>Web: {{ $invoice['company_website'] }}</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-black mb-3 uppercase tracking-wider">Kepada</h2>
                        <div class="text-gray-700 text-sm">
                            <p class="font-bold text-base mb-2">{{ $invoice['client_name'] }}</p>
                            @if(!empty($invoice['client_address']))
                                <p class="whitespace-pre-line">{{ $invoice['client_address'] }}</p>
                            @endif
                            <p class="mt-1">No. HP: {{ $invoice['client_phone'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <table class="w-full mb-8">
                    <thead>
                        <tr class="bg-black text-white">
                            <th class="text-left py-4 px-4 font-bold text-xs uppercase tracking-wider">Deskripsi</th>
                            <th class="text-center py-4 px-4 font-bold text-xs uppercase tracking-wider">Jumlah</th>
                            <th class="text-right py-4 px-4 font-bold text-xs uppercase tracking-wider">Harga Satuan</th>
                            <th class="text-right py-4 px-4 font-bold text-xs uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice['items'] as $item)
                            <tr class="border-b border-gray-200">
                                <td class="py-4 px-4 text-sm">{{ $item['description'] }}</td>
                                <td class="text-center py-4 px-4 text-sm">{{ $item['quantity'] }}</td>
                                <td class="text-right py-4 px-4 text-sm">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="text-right py-4 px-4 text-sm font-semibold">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Totals -->
                <div class="flex justify-end mb-12">
                    <div class="w-80">
                        <div class="flex justify-between py-4 bg-black text-white px-4 text-xl font-bold">
                            <span>TOTAL:</span>
                            <span>Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="text-center text-gray-600 text-sm pt-8 border-t-2 border-black">
                    <p class="font-bold mb-2">Terima kasih atas kepercayaan Anda!</p>
                    <p class="text-xs italic">Pembayaran jatuh tempo dalam {{ \Carbon\Carbon::parse($invoice['invoice_date'])->diffInDays(\Carbon\Carbon::parse($invoice['due_date'])) }} hari. Mohon lakukan pembayaran sesuai detail yang tertera.</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
