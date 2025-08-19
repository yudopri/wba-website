<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\User;
use App\Models\SaldoUtama;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    public function index(Request $request)
{
    $query = Invoice::query();

    // Filter pencarian nama perusahaan
    if ($request->filled('search')) {
        $query->where('nama_perusahaan', 'like', '%' . $request->search . '%');
    }

    // Filter bulan awal & akhir
    if ($request->filled('bulan_awal')) {
        $query->whereDate('bulan', '>=', $request->bulan_awal . '-01');
    }
    if ($request->filled('bulan_akhir')) {
        $query->whereDate('bulan', '<=', $request->bulan_akhir . '-31');
    }

    // Filter status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    $invoices = $query->paginate(10);

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
    ]);

    $validated['id_user'] = auth()->id();

    // Override date_send dengan tanggal sekarang
    $validated['date_send'] = now();
     $validated['bulan'] = $request->bulan . '-01';
    $validated['status'] = 'pending'; // Set status default

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
]);
// Override date_send dengan tanggal sekarang
    $validated['date_send'] = now();

     $validated['bulan'] = $request->bulan . '-01';

$invoice->update($validated);


        return redirect()->route('admin.invoice.index')->with('success', 'Invoice berhasil diperbarui.');
    }

   public function destroy(Invoice $invoice)
{
    // Ambil saldo terakhir
    $saldo = SaldoUtama::latest('id')->first();

    if ($saldo) {
        // Rollback nominal invoice (misal hanya kalau status sudah paid)
        if ($invoice->status === 'paid') {
            $saldoBaru = $saldo->saldo - $invoice->nominal;

            // Simpan saldo baru
            SaldoUtama::create([
                'id_user' => Auth::id(),
                'debit' => 0,
                'kredit' => 0,
                'saldo' => $saldoBaru,
            ]);
        }
    }

    // Hapus invoice
    $invoice->delete();

    return redirect()->route('admin.invoice.index')->with('success', 'Invoice dan saldo utama berhasil dihapus.');
}
    public function upload(Request $request, $id)
{
    $Invoice = Invoice::findOrFail($id);

    if ($request->hasFile('foto_bukti')) {
        $file = $request->file('foto_bukti');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('assets/bukti_invoice'), $filename);

        $Invoice->foto_bukti = 'assets/bukti_invoice/' . $filename;

        if ($Invoice->status == 'pending') {
            $Invoice->status = 'paid';
            $Invoice->date_pay = now();
            $Invoice->save();

            // Hitung saldo terakhir untuk user ini
            $lastBalance = SaldoUtama::where('id_user', $Invoice->id_user)
                ->orderBy('created_at', 'desc')
                ->first();

            $saldoTerakhir = $lastBalance ? $lastBalance->saldo : 0;

            // Hitung saldo baru
            $saldoBaru = $saldoTerakhir + $Invoice->nominal;


            // Simpan ke saldo utama dengan saldo baru
            SaldoUtama::create([
                'id_user' => Auth::id(),
                'debit' => 0,
                'kredit' => $Invoice->nominal,
                'saldo' => $saldoBaru,
            ]);
        } else {
            $Invoice->save();
        }
    }

    return redirect()->back()->with('success', 'Bukti pembayaran berhasil diupload dan status diupdate.');
}

}
