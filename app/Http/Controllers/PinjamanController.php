<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SaldoUtama;
class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        // Filter tanggal
        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            // Default: 7 hari terakhir
            $tanggalAwal = now()->subDays(7)->startOfDay();
            $tanggalAkhir = now()->endOfDay();
        }

        // Ambil transaksi pinjaman sesuai range tanggal
        $transaksi = Pinjaman::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Hitung saldo total dari semua waktu
        $saldo = Pinjaman::sum('debit') - Pinjaman::sum('kredit');

        // Hitung total pinjaman (kredit) dalam periode filter
        $totalKredit = Pinjaman::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                            ->sum('kredit');

        return view('admin.pinjaman.index', compact('transaksi', 'saldo', 'totalKredit'))
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

           // Ambil saldo terakhir per user dari SaldoUtama
         $lastBalance = SaldoUtama::where('id_user', Auth::id())
        ->orderBy('created_at', 'desc')
        ->first();

        $saldoTerakhir = $lastBalance ? $lastBalance->saldo : 0;
         $saldoBaru = $saldoTerakhir - $request->debit;

        // Simpan ke SaldoUtama
        SaldoUtama::create([
        'id_user' => Auth::id(),
        'debit' => $request->debit,
        'kredit' => 0,
        'saldo' => $saldoBaru,
             ]);
        $lastSaldo = Pinjaman::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        Pinjaman::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $saldoBaru,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pinjaman berhasil ditambahkan.');
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:0',
        ]);

        $lastSaldo = Pinjaman::latest()->first()?->saldo ?? 0;
        $saldoBaru = $lastSaldo - $request->kredit;

        if ($saldoBaru < 0) {
            return redirect()->back()->with('error', 'Saldo pinjaman tidak mencukupi.');
        }

        Pinjaman::create([
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $saldoBaru,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pembayaran pinjaman berhasil.');
    }

    public function destroy($id)
    {
        $pinjaman = Pinjaman::findOrFail($id);
        $pinjaman->delete();

        return redirect()->back()->with('success', 'Data pinjaman berhasil dihapus.');
    }
}
