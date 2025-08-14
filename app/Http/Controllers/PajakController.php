<?php

namespace App\Http\Controllers;

use App\Models\Pajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SaldoUtama;

class PajakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

        $transaksi = Pajak::with('user')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('created_at', 'desc')
            ->get();

        $saldo = Pajak::sum('debit') - Pajak::sum('kredit');
        $totalPengeluaran = Pajak::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->sum('kredit');

        return view('admin.pajak.index', compact(
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
$validated['id_user'] = Auth::id();

    // Ambil saldo terakhir per user dari SaldoUtama
    $lastBalance = SaldoUtama::latest()->first();

    $saldoTerakhir = $lastBalance ? $lastBalance->saldo : 0;
    $saldoBaru = $saldoTerakhir - $request->debit;

    // Simpan ke SaldoUtama
    SaldoUtama::create([
        'id_user' => Auth::id(),
        'debit' => $request->debit,
        'kredit' => 0,
        'saldo' => $saldoBaru,
    ]);

    // Ambil saldo terakhir global Pajak
    $lastSaldoLogistik = Pajak::orderBy('created_at', 'desc')->value('saldo') ?? 0;

    // Simpan ke Pajak (pengeluaran)
    Pajak::create([
        'id_user' => Auth::id(),
        'keterangan' => $request->keterangan,
        'debit' => $request->debit,
        'kredit' => 0,
        'saldo' => $lastSaldoLogistik - $request->debit, // saldo logistik berkurang
    ]);

    return redirect()->back()->with('success', 'Saldo berhasil diperbarui.');
}


    public function kredit(Request $request)
    {
        $request->validate([
    'keterangan' => 'required|string|max:255',
    'debit' => 'required|numeric|min:1',
]);
$validated['id_user'] = auth()->id();


        $lastSaldo = Pajak::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        if ($request->kredit > $lastSaldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pengeluaran.');
        }

        Pajak::create([
            'id_user' => Auth::id(),
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $lastSaldo - $request->kredit,
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
    }
}
