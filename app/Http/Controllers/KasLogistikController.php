<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasLogistik;

class KasLogistikController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = KasLogistik::orderBy('created_at', 'desc')->get();
        $saldo = KasLogistik::latest()->first()->saldo_setelah ?? 0;

        // Filter range waktu
        $range = $request->input('range', '7hari');
        $tanggalAwal = match($range) {
            '1bulan' => now()->subMonth(),
            '3bulan' => now()->subMonths(3),
            '1tahun' => now()->subYear(),
            default => now()->subDays(7),
        };

        $totalPengeluaran = KasLogistik::where('created_at', '>=', $tanggalAwal)
            ->sum('kredit');

        return view('admin.kaslogistik.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'range'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'debit' => 'required|integer|min:1',
        ]);

        $saldoTerakhir = KasLogistik::latest()->first()->saldo_setelah ?? 0;

        KasLogistik::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo_setelah' => $saldoTerakhir + $request->debit,
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan');
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'kredit' => 'required|integer|min:1',
        ]);

        $saldoTerakhir = KasLogistik::latest()->first()->saldo_setelah ?? 0;

        if ($request->kredit > $saldoTerakhir) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi');
        }

        KasLogistik::create([
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo_setelah' => $saldoTerakhir - $request->kredit,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat');
    }
}
