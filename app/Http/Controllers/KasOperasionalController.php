<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KasOperasional;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class KasOperasionalController extends Controller
{
    public function index(Request $request)
<<<<<<< HEAD
    {
        $range = $request->get('range', '7hari');

        $tanggalAwal = match ($range) {
            '1bulan' => now()->subMonth(),
            '3bulan' => now()->subMonths(3),
            '1tahun' => now()->subYear(),
            default => now()->subDays(7),
        };

        // Ambil transaksi berdasarkan range
        $transaksi = KasOperasional::where('created_at', '>=', $tanggalAwal)
                        ->orderBy('created_at', 'desc')
                        ->get();

        $saldo = KasOperasional::sum('debit') - KasOperasional::sum('kredit');

        $totalPengeluaran = KasOperasional::where('created_at', '>=', $tanggalAwal)->sum('kredit');

        return view('admin.kasoperasional.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'range'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:1',
        ]);

        $lastSaldo = KasOperasional::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        KasOperasional::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $lastSaldo + $request->debit,
            'id_user' => Auth::id(),
        ]);
=======
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
    $totalPengeluaran = KasOperasional::whereBetween('created_at', [$tanggalMulai, $tanggalSelesai])->sum('kredit');

    return view('admin.kasoperasional.index', compact('transaksi', 'saldo', 'totalPengeluaran', 'tanggalMulai', 'tanggalSelesai'));
}
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'debit' => 'required|numeric|min:1',
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
            'kredit' => 'required|numeric|min:1',
        ]);

        $lastSaldo = KasOperasional::orderBy('created_at', 'desc')->value('saldo') ?? 0;

        if ($request->kredit > $lastSaldo) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk pengeluaran.');
        }

        KasOperasional::create([
            'keterangan' => $request->keterangan,
            'debit' => 0,
            'kredit' => $request->kredit,
            'saldo' => $lastSaldo - $request->kredit,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Pengeluaran berhasil disimpan.');
    }
}
