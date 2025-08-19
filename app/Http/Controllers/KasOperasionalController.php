<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasOperasional;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SaldoUtama;

class KasOperasionalController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai');
        $tanggalSelesai = $request->input('tanggal_selesai');

        // Default tanggal jika tidak diisi
        if (!$tanggalMulai || !$tanggalSelesai) {
            $tanggalMulai = now()->subDays(7)->startOfDay();
            $tanggalSelesai = now()->endOfDay();
        } else {
            $tanggalMulai = Carbon::parse($tanggalMulai)->startOfDay();
            $tanggalSelesai = Carbon::parse($tanggalSelesai)->endOfDay();
        }

        $transaksi = KasOperasional::whereBetween('created_at', [$tanggalMulai, $tanggalSelesai])
            ->orderBy('created_at', 'desc')
            ->get();

        $saldo = KasOperasional::sum('debit') - KasOperasional::sum('kredit');
        $totalPengeluaran = KasOperasional::whereBetween('created_at', [$tanggalMulai, $tanggalSelesai])
            ->sum('kredit');

        return view('admin.kasoperasional.index', compact(
            'transaksi',
            'saldo',
            'totalPengeluaran',
            'tanggalMulai',
            'tanggalSelesai'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
        'keterangan' => 'required|string|max:255',
        'debit' => 'required|numeric|min:1',
        ]);

        $lastBalance = SaldoUtama::latest()->first();

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

        $lastSaldo = KasOperasional::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        KasOperasional::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $lastSaldo + $request->debit,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }

   public function kredit(Request $request)
{
    $request->validate([
        'keterangan' => 'required|string|max:255',
        'kredit' => 'required|numeric|min:1', // ubah debit -> kredit
        'created_at' => 'required|date',
    ]);

    $lastSaldo = KasOperasional::latest()->first()?->saldo ?? 0;
        $saldoBaru = $lastSaldo - $request->kredit;

        if ($saldoBaru < 0) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk transaksi ini.');
        }

    KasOperasional::create([
        'keterangan' => $request->keterangan,
        'debit' => 0,
        'kredit' => $request->kredit,
        'saldo' => $saldoBaru,
        'created_at' => $request->created_at,
        'id_user' => Auth::id(),
    ]);

    return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
}
    public function destroy($id)
    {
        $kasOperasional = KasOperasional::findOrFail($id);
        // --- Update saldo utama kalau debit ---
    $saldoUtama = SaldoUtama::latest('id')->first();
    if ($saldoUtama && $kasOperasional->debit > 0) {
        $saldoBaru = $saldoUtama->saldo - $kasOperasional->debit;

        SaldoUtama::create([
            'id_user' => Auth::id(),
            'debit' => 0,
            'kredit' => 0,
            'saldo' => $saldoBaru,
        ]);
    }

    // --- Update saldo BPJS kalau kredit ---
    $saldokasOperasionalTerakhir = KasOperasional::latest('id')->first();
    if ($saldokasOperasionalTerakhir && $kasOperasional->kredit > 0) {
        $saldoBarukasOperasional = $saldokasOperasionalTerakhir->saldo + $kasOperasional->kredit;

        KasOperasional::create([
            'id_user' => Auth::id(),
            'debit' => 0,
            'kredit' => 0,
            'saldo' => $saldoBarukasOperasional,
        ]);
    }
        $kasOperasional->delete();

        return redirect()->back()->with('success', 'Transaksi kas operasional berhasil dihapus.');
    }

}
