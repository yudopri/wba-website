<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogisticsCash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SaldoUtama;

class KasLogistikController extends Controller
{
    public function index(Request $request)
    {
        // Ambil range, default 7 hari
        $range = $request->get('range', '7hari');

        // Tentukan tanggal awal dan akhir
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

        // Ambil data transaksi sesuai filter
        $transaksi = LogisticsCash::with('user')
            ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung saldo akhir global
        $saldo = LogisticsCash::sum('debit') - LogisticsCash::sum('kredit');

        // Hitung total pengeluaran sesuai filter
        $totalPengeluaran = LogisticsCash::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])->sum('kredit');

        return view('admin.kaslogistik.index', compact(
            'transaksi', 'saldo', 'totalPengeluaran', 'range'
        ))->with([
            'tanggal_awal' => $request->tanggal_awal,
            'tanggal_akhir' => $request->tanggal_akhir,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:1',
        ]);

        $validated['id_user'] = Auth::id();

        // Ambil saldo terakhir per user dari SaldoUtama
         $saldoTerakhir = $lastBalance ? $lastBalance->saldo : 0;

    // Cek jika saldo tidak cukup
    if ($saldoTerakhir <= 0 || $saldoTerakhir < $request->debit) {
        return redirect()->back()->with('error', 'Saldo tidak cukup untuk melakukan transaksi ini.');
    }

    // Hitung saldo baru
    $saldoBaru = $saldoTerakhir - $request->debit;

    // Simpan ke SaldoUtama
    SaldoUtama::create([
        'id_user' => Auth::id(),
        'debit' => $request->debit,
        'kredit' => 0,
        'saldo' => $saldoBaru,
    ]);


        // Ambil saldo terakhir global LogisticsCash
        $lastSaldoLogistik = LogisticsCash::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        // Simpan ke LogisticsCash (pengeluaran)
        LogisticsCash::create([
            'id_user' => $validated['id_user'],
            'keterangan' => $validated['keterangan'],
            'debit' => $validated['debit'],
            'kredit' => 0,
            'saldo' => $lastSaldoLogistik + $request->debit, // saldo logistik berkurang
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil diperbarui.');
    }

    public function kredit(Request $request)
    {
        $validated = $request->validate([
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:1',
            'created_at' => 'required|date',
        ]);

        $validated['id_user'] = Auth::id();

        // Ambil saldo terakhir global
        $lastSaldo = LogisticsCash::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        if ($validated['kredit'] > $lastSaldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pengeluaran.');
        }

        LogisticsCash::create([
            'id_user' => $validated['id_user'],
            'keterangan' => $validated['keterangan'],
            'debit' => 0,
            'kredit' => $validated['kredit'],
            'saldo' => $lastSaldo - $validated['kredit'],
            'created_at' => $validated['created_at'],
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
    }
    public function destroy($id)
    {
        $kasLogistik = LogisticsCash::findOrFail($id);
        // --- Update saldo utama kalau debit ---
    $saldoUtama = SaldoUtama::latest('id')->first();
    if ($saldoUtama && $kasLogistik->debit > 0) {
        $saldoBaru = $saldoUtama->saldo + $kasLogistik->debit;

        SaldoUtama::create([
            'id_user' => Auth::id(),
            'debit' => 0,
            'kredit' => 0,
            'saldo' => $saldoBaru,
        ]);
    }

    // --- Update saldo BPJS kalau kredit ---
    $saldoLogisticsCashTerakhir = LogisticsCash::latest('id')->first();
    if ($saldoLogisticsCashTerakhir && $kasLogistik->kredit > 0) {
        $saldoBaruLogisticsCash = $saldoLogisticsCashTerakhir->saldo + $kasLogistik->kredit;

        LogisticsCash::create([
            'id_user' => Auth::id(),
            'debit' => 0,
            'kredit' => 0,
            'saldo' => $saldoBaruLogisticsCash,
        ]);
    }
        $kasLogistik->delete();

        return redirect()->back()->with('success', 'Transaksi kas logistik berhasil dihapus.');
    }
}
