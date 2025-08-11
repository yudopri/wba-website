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

        // Default tanggal
        $tanggalAwal = now()->subDays(7);
        $tanggalAkhir = now();

        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            $tanggalAwal = match ($range) {
                '1bulan' => now()->subMonth(),
                '3bulan' => now()->subMonths(3),
                '1tahun' => now()->subYear(),
                default => now()->subDays(7),
            };
            $tanggalAkhir = now();
        }

        $transaksi = LogisticsCash::with('user')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('created_at', 'desc')
            ->get();

        $saldo = LogisticsCash::sum('debit') - LogisticsCash::sum('kredit');
        $totalPengeluaran = LogisticsCash::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->sum('kredit');

        return view('admin.kaslogistik.index', compact(
            'transaksi',
            'saldo',
            'totalPengeluaran',
            'range'
        ))->with([
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:1',
        ]);

        $lastSaldo = LogisticsCash::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        LogisticsCash::create([
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

        LogisticsCash::create([
            'id_user' => Auth::id(),
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $lastSaldo - $request->kredit,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
    }
}
