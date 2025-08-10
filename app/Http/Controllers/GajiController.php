<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiLog;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    // Tampilkan semua data gaji
    public function index(Request $request)
{
    $query = Gaji::query();

    // Filter berdasarkan bulan
    if ($request->has('gada') && $request->gada != '') {
        $query->where('bulan', $request->gada);
    }

    $dataGaji = $query->latest()->get();

    return view('admin.gaji.index', compact('dataGaji'));
}


    // Tampilkan form tambah gaji
    public function create()
    {
        return view('admin.gaji.create');
    }

    // Simpan data gaji baru dan buat log
   public function store(Request $request)
{
    $request->validate([
        'id_karyawan' => 'required|numeric',
        'nominal'     => 'required|numeric',
        'bulan'       => 'required|integer|min:1|max:12', // karena kamu pakai angka 1-12 di form
    ]);

    $gaji = Gaji::create([
        'id_karyawan' => $request->id_karyawan,
        'id_user'     => Auth::id(), // diisi otomatis dari user yang login
        'nominal'     => $request->nominal,
        'bulan'       => $request->bulan,
    ]);

    $gaji->logs()->create([
        'keterangan' => 'Data dibuat',
        'person'     => Auth::user()->name ?? 'System',
        'deskripsi'  => 'Data penggajian berhasil ditambahkan.',
    ]);

    return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil ditambahkan.');
}


    // Tampilkan detail gaji
    public function show($id)
    {
        $gaji = Gaji::with('logs')->findOrFail($id);
        return view('admin.gaji.detail', compact('gaji'));
       $gaji = Gaji::with(['karyawan', 'user', 'logs'])->findOrFail($id);


    }

    // Konfirmasi gaji (jika Anda ingin tetap punya status, harus tambahkan kolom status di tabel salaries)
    public function konfirmasi($id)
    {
        $gaji = Gaji::findOrFail($id);

        // Jika kolom `status` sudah dihapus, bagian ini akan error. Bisa dihapus atau dibiarkan jika Anda ingin menambahkan kembali kolom `status`.
        // $gaji->update(['status' => 'Dikonfirmasi']);

        $gaji->logs()->create([
            'keterangan' => 'Dikonfirmasi',
            'person'     => Auth::user()->name ?? 'System',
            'deskripsi'  => 'Data penggajian telah dikonfirmasi.',
        ]);

        return back()->with('success', 'Data gaji berhasil dikonfirmasi.');
    }

}
