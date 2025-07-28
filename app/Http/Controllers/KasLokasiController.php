<?php

namespace App\Http\Controllers;

use App\Models\KasLokasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KasLokasiController extends Controller
{
    public function index(Request $request)
    {
        // Range filter
        $range = $request->input('range', '7hari');
        $tanggalMulai = match ($range) {
            '1bulan' => now()->subMonth(),
            '3bulan' => now()->subMonths(3),
            '1tahun' => now()->subYear(),
            default => now()->subDays(7),
        };

        $transaksi = KasLokasi::where('created_at', '>=', $tanggalMulai)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $saldo = KasLokasi::sum('debit') - KasLokasi::sum('kredit');
        $totalPengeluaran = KasLokasi::where('created_at', '>=', $tanggalMulai)->sum('kredit');

        return view('admin.kaslokasi.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'range'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:0',
        ]);

        $lastSaldo = KasLokasi::latest()->first()?->saldo ?? 0;
        $saldoBaru = $lastSaldo + $request->debit;

        KasLokasi::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $saldoBaru,
            'lokasi_kerja' => null, // tidak diinput dari form
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:0',
            'lokasi' => 'required|string|max:255',
        ]);

        $lastSaldo = KasLokasi::latest()->first()?->saldo ?? 0;
        $saldoBaru = $lastSaldo - $request->kredit;

        if ($saldoBaru < 0) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk transaksi ini.');
        }

        KasLokasi::create([
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $saldoBaru,
            'lokasi_kerja' => $request->lokasi,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }
}
