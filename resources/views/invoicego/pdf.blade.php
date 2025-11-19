<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice['invoice_number'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #000;
            background: #fff;
            padding: 40px;
        }
        
        .header {
            border-bottom: 4px solid #000;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        
        .header h1 {
            font-size: 48px;
            font-weight: bold;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        
        .invoice-details {
            text-align: right;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .invoice-details strong {
            font-weight: bold;
        }
        
        .parties {
            display: table;
            width: 100%;
            margin-bottom: 40px;
        }
        
        .party {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            padding-right: 20px;
        }
        
        .party h2 {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .party-info {
            font-size: 11px;
            line-height: 1.6;
        }
        
        .party-name {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        thead {
            background: #000;
            color: #fff;
        }
        
        thead th {
            padding: 12px;
            text-align: left;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        thead th.text-center {
            text-align: center;
        }
        
        thead th.text-right {
            text-align: right;
        }
        
        tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        
        tbody td.text-center {
            text-align: center;
        }
        
        tbody td.text-right {
            text-align: right;
        }
        
        .totals {
            width: 300px;
            margin-left: auto;
            margin-top: 20px;
        }
        
        .totals-row {
            display: table;
            width: 100%;
            padding: 8px 0;
            font-size: 12px;
        }
        
        .totals-row.subtotal {
            border-top: 1px solid #ddd;
        }
        
        .totals-row.grand-total {
            background: #000;
            color: #fff;
            padding: 15px 12px;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
        
        .totals-label {
            display: table-cell;
            text-align: left;
            padding-left: 12px;
        }
        
        .totals-value {
            display: table-cell;
            text-align: right;
            padding-right: 12px;
        }
        
        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #000;
            text-align: center;
            font-size: 10px;
            color: #666;
        }
        
        .footer-note {
            margin-top: 10px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <div class="invoice-details">
            <div><strong>No. Invoice:</strong> {{ $invoice['invoice_number'] }}</div>
            <div><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($invoice['invoice_date'])->locale('id')->isoFormat('D MMMM YYYY') }}</div>
            <div><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($invoice['due_date'])->locale('id')->isoFormat('D MMMM YYYY') }}</div>
        </div>
    </div>

    <div class="parties">
        <div class="party">
            <h2>Dari</h2>
            <div class="party-info">
                <div class="party-name">{{ $invoice['company_name'] }}</div>
                <div>{{ nl2br($invoice['company_address']) }}</div>
                @if(!empty($invoice['company_phone']))
                    <div>Telepon: {{ $invoice['company_phone'] }}</div>
                @endif
                <div>Email: {{ $invoice['company_email'] }}</div>
                @if(!empty($invoice['company_website']))
                    <div>Web: {{ $invoice['company_website'] }}</div>
                @endif
            </div>
        </div>
        
        <div class="party">
            <h2>Kepada</h2>
            <div class="party-info">
                <div class="party-name">{{ $invoice['client_name'] }}</div>
                @if(!empty($invoice['client_address']))
                    <div>{{ nl2br($invoice['client_address']) }}</div>
                @endif
                <div>No. HP: {{ $invoice['client_phone'] }}</div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-center">Jumlah</th>
                <th class="text-right">Harga Satuan</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice['items'] as $item)
                <tr>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-center">{{ $item['quantity'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="totals-row grand-total">
            <div class="totals-label">TOTAL:</div>
            <div class="totals-value">Rp {{ number_format($grandTotal, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="footer">
        <div><strong>Terima kasih atas kepercayaan Anda!</strong></div>
        <div class="footer-note">Pembayaran jatuh tempo dalam {{ \Carbon\Carbon::parse($invoice['invoice_date'])->diffInDays(\Carbon\Carbon::parse($invoice['due_date'])) }} hari. Mohon lakukan pembayaran sesuai detail yang tertera.</div>
    </div>
</body>
</html>
