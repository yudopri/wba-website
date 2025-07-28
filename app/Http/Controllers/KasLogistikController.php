<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogisticsCash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KasLogistikController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', '7hari');

        // Filter waktu berdasarkan range
        $tanggalAwal = match ($range) {
            '1bulan' => now()->subMonth(),
            '3bulan' => now()->subMonths(3),
            '1tahun' => now()->subYear(),
            default => now()->subDays(7),
        };

        // Ambil data transaksi
        $transaksi = LogisticsCash::with('user')
            ->where('created_at', '>=', $tanggalAwal)
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung saldo akhir
        $saldo = LogisticsCash::sum('debit') - LogisticsCash::sum('kredit');

        // Hitung total pengeluaran (kredit) sesuai range
        $totalPengeluaran = LogisticsCash::where('created_at', '>=', $tanggalAwal)->sum('kredit');

        return view('admin.kaslogistik.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'range'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:1',
        ]);

        $lastSaldo = LogisticsCash::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        $log = LogisticsCash::create([
            'id_user' => Auth::id(),
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $lastSaldo + $request->debit,
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:1',
        ]);

        $lastSaldo = LogisticsCash::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        if ($request->kredit > $lastSaldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pengeluaran.');
        }

        $log = LogisticsCash::create([
            'id_user' => Auth::id(),
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $lastSaldo - $request->kredit,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
    }
}
