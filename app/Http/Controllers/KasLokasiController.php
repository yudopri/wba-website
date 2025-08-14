<?php

namespace App\Http\Controllers;

use App\Models\KasLokasi;
use App\Models\SaldoUtama;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Employee;

class KasLokasiController extends Controller
{
    public function index(Request $request)
    { $userName = Auth::user()->name; // atau bisa pak
    $employee = Employee::where('name', $userName)->first();
        if (!$employee) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        // Ambil lokasi kerja user
    $userLokasi = $employee->lokasikerja;
        // Ambil filter tanggal jika ada
        if ($request->filled(['tanggal_awal', 'tanggal_akhir'])) {
            $tanggalAwal = Carbon::parse($request->tanggal_awal)->startOfDay();
            $tanggalAkhir = Carbon::parse($request->tanggal_akhir)->endOfDay();
        } else {
            $tanggalAwal = now()->subDays(7)->startOfDay();
            $tanggalAkhir = now()->endOfDay();
        }

        // Ambil data transaksi sesuai range tanggal
        $transaksi = KasLokasi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
       -> where('lokasi_kerja', $userLokasi)
                        ->orderBy('created_at', 'desc')
                        ->get();

        // Hitung saldo total (dari semua waktu)
        $saldo = KasLokasi::sum('debit') - KasLokasi::sum('kredit');

        // Total pengeluaran dari range yang difilter
        $totalPengeluaran = KasLokasi::whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
                            ->sum('kredit');

        // Ambil daftar lokasi aktif dari model Work
        $lokasiKerja = Work::where('status', 'aktif')->pluck('name');

        return view('admin.kaslokasi.index', compact(
            'transaksi', 'saldo', 'totalPengeluaran', 'lokasiKerja','userLokasi'
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
            'lokasi' => 'nullable|string|max:255',
        ]);

        // Ambil saldo terakhir per user dari SaldoUtama
        $lastBalance = SaldoUtama::latest()->first();

        $saldoTerakhir = $lastBalance ? $lastBalance->saldo : 0;
        $saldoBaruSaldoUtama = $saldoTerakhir - $request->debit;

        // Simpan ke SaldoUtama
        SaldoUtama::create([
            'id_user' => Auth::id(),
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $saldoBaruSaldoUtama,
        ]);

        // Hitung saldo terbaru untuk KasLokasi
        $lastSaldo = KasLokasi::latest()->first()?->saldo ?? 0;
        $saldoBaruKasLokasi = $lastSaldo + $request->debit;

        // Simpan ke KasLokasi
        KasLokasi::create([
            'keterangan' => $request->keterangan,
            'debit' => $request->debit,
            'kredit' => 0,
            'saldo' => $saldoBaruKasLokasi,
            'lokasi_kerja' => $request->lokasi,
            'id_user' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Saldo berhasil ditambahkan.');
    }

    public function kredit(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'kredit' => 'required|numeric|min:1',
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
