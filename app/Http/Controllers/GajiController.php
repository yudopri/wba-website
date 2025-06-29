<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiLog;

class GajiController extends Controller
{
    // Tampilkan semua data gaji
    public function index(Request $request)
    {
        $query = Gaji::query();

        // Filter berdasarkan nama perusahaan
        if ($request->has('search') && $request->search != '') {
            $query->where('nama_pt', 'like', '%' . $request->search . '%');
        }

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
            'nama_pt' => 'required|string|max:255',
            'nominal' => 'required|numeric',
            'bulan' => 'required|string|max:20',
        ]);

        $gaji = Gaji::create([
            'nama_pt' => $request->nama_pt,
            'nominal' => $request->nominal,
            'bulan' => $request->bulan,
            'status' => 'Menunggu',
        ]);

        // Tambahkan log otomatis
        $gaji->logs()->create([
            'keterangan' => 'Data dibuat',
            'person' => auth()->user()->name ?? 'System',
            'deskripsi' => 'Data penggajian berhasil ditambahkan.',
        ]);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil ditambahkan.');
    }

    // Tampilkan detail gaji
    public function show($id)
    {
        $gaji = Gaji::with('logs')->findOrFail($id);
        return view('admin.gaji.detail', compact('gaji'));
    }

    // Konfirmasi gaji
    public function konfirmasi($id)
    {
        $gaji = Gaji::findOrFail($id);
        $gaji->update(['status' => 'Dikonfirmasi']);

        // Tambahkan log konfirmasi
        $gaji->logs()->create([
            'keterangan' => 'Dikonfirmasi',
            'person' => auth()->user()->name ?? 'System',
            'deskripsi' => 'Data penggajian telah dikonfirmasi.',
        ]);

        return back()->with('success', 'Data gaji berhasil dikonfirmasi.');
    }
}
