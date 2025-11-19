<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        return view('invoicego.index');
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date',
            'company_name' => 'required|string',
            'company_email' => 'required|email',
            'company_phone' => 'nullable|string',
            'company_website' => 'nullable|string',
            'company_address' => 'required|string',
            'client_name' => 'required|string',
            'client_address' => 'nullable|string',
            'client_phone' => 'required|string',
            'items' => 'required|array',
            'items.*.description' => 'required|string',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        // Calculate totals
        $grandTotal = 0;
        foreach ($validated['items'] as &$item) {
            $item['total'] = $item['quantity'] * $item['price'];
            $grandTotal += $item['total'];
        }

        $data = [
            'invoice' => $validated,
            'grandTotal' => $grandTotal,
        ];

        // Check if download PDF is requested
        if ($request->has('download')) {
            $pdf = Pdf::loadView('invoicego.pdf', $data);
            return $pdf->download('invoice-' . $validated['invoice_number'] . '.pdf');
        }

        return view('invoicego.preview', $data);
    }
}
