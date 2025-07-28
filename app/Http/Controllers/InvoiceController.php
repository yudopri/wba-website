<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('user')->latest()->paginate(10);
        return view('admin.invoice.index', compact('invoices'));
    }

    public function create()
{
    $works = \App\Models\Work::all();
    return view('admin.invoice.form', compact('works'));
}


    public function store(Request $request)
    {
        $validated = $request->validate([
    'lokasi_kerja' => 'required|string',
    'jumlah_personil' => 'required|integer',
    'nominal' => 'required|numeric',
    'bulan' => 'required|string',
    'date_send' => 'nullable|date',
    'date_pay' => 'nullable|date',
    'status' => 'required|string',
]);

$validated['id_user'] = auth()->id();

Invoice::create($validated);


        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil ditambahkan.');
    }

    public function show(Invoice $invoice)
    {
        return view('admin.invoice.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
{
    $works = \App\Models\Work::all();
    return view('admin.invoice.form', compact('invoice', 'works'));
}


    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
    'lokasi_kerja' => 'required|string',
    'jumlah_personil' => 'required|integer',
    'nominal' => 'required|numeric',
    'bulan' => 'required|string',
    'date_send' => 'nullable|date',
    'date_pay' => 'nullable|date',
    'status' => 'required|string',
]);

$invoice->update($validated);


        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil diperbarui.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil dihapus.');
    }
}
