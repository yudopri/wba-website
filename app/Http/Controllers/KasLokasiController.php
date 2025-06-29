<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasLokasi;

class KasLokasiController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = KasLokasi::orderBy('created_at', 'desc')->get();
        $saldo = KasLokasi::latest()->first()->saldo_setelah ?? 0;

        // Range waktu filter pengeluaran
        $range = $request->input('range', '7hari');
        $tanggalAwal = match($range) {
            '1bulan' => now()->subMonth(),
            '3bulan' => now()->subMonths(3),
            '1tahun' => now()->subYear(),
            default => now()->subDays(7),
        };

        $totalPengeluaran = KasLokasi::where('created_at', '>=', $tanggalAwal)->sum('kredit');

        return view('admin.kaslokasi.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'range'));
    }

    public function store(Request $request)
{
    $request->validate([
        'keterangan' => 'required|string',
        'debit' => 'required|integer|min:1',
    ]);

    $saldoTerakhir = KasLokasi::latest()->first()->saldo_setelah ?? 0;

    KasLokasi::create([
        'keterangan' => $request->keterangan,
        'debit' => $request->debit,
        'kredit' => 0,
        'saldo_setelah' => $saldoTerakhir + $request->debit,
        'lokasi' => '-', // lokasi default
    ]);

    return redirect()->back()->with('success', 'Saldo berhasil ditambahkan');
}


    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'kredit' => 'required|integer|min:1',
            'lokasi' => 'required|string',
        ]);

        $saldoTerakhir = KasLokasi::latest()->first()->saldo_setelah ?? 0;

        if ($request->kredit > $saldoTerakhir) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi');
        }

        KasLokasi::create([
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo_setelah' => $saldoTerakhir - $request->kredit,
            'lokasi' => $request->lokasi,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat');
    }
}
