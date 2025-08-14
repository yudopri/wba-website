<?php

namespace App\Http\Controllers;

use App\Models\SaldoUtama;
use Illuminate\Http\Request;
use App\Models\KasLokasi;
use App\Models\KasOperasional;
use App\Models\LogisticsCash;
use App\Models\Invoice;
use App\Models\Pajak;
use App\Models\Bpjs;
use App\Models\Pinjaman;
use App\Models\Gaji;

class SaldoUtamaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Ambil semua data SaldoUtama
    $saldoUtama = SaldoUtama::latest()->first();

    // Ambil semua kas lokasi
    $kasLokasi = KasLokasi::latest()->first();

    // Ambil semua kas operasional
    $kasOperasional = KasOperasional::latest()->first();

    // Ambil semua kas logistik
    $logisticsCash = LogisticsCash::latest()->first();

    // Ambil semua pajak
    $pajak = Pajak::latest()->first();
    // Ambil semua BPJS
    $bpjs = Bpjs::latest()->first();
    // Ambil semua pinjaman
    $pinjaman = Pinjaman::latest()->first();

    // Ambil semua gaji
    $gaji = Gaji::latest()->first();

    $invoicePaid = Invoice::where('status', 'paid')
        ->latest()
        ->get();

    $invoice = $invoicePaid->sum('nominal');
    return view('admin.saldo.index', compact(
        'saldoUtama',
        'kasLokasi',
        'kasOperasional',
        'logisticsCash',
        'invoice',
        'pajak',
        'bpjs',
        'pinjaman',
        'gaji'
    ));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SaldoUtama $saldoUtama)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaldoUtama $saldoUtama)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SaldoUtama $saldoUtama)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaldoUtama $saldoUtama)
    {
        //
    }
}
