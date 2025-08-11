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
        // Ambil filter tanggal jika ada
        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            // Default: 7 hari terakhir
            $tanggalAwal = now()->subDays(7)->startOfDay();
            $tanggalAkhir = now()->endOfDay();
        }

        // Ambil data sesuai range tanggal
        $transaksi = KasLokasi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Hitung saldo total (dari semua waktu)
        $saldo = KasLokasi::sum('debit') - KasLokasi::sum('kredit');

        // Total pengeluaran dari range yang difilter
        $totalPengeluaran = KasLokasi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                            ->sum('kredit');

        return view('admin.kaslokasi.index', compact('transaksi', 'saldo', 'totalPengeluaran'))
            ->with([
                'tanggal_awal' => $request->tanggal_awal,
                'tanggal_akhir' => $request->tanggal_akhir,
            ]);
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
            'lokasi_kerja' => null,
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
