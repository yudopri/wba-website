<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengaduanController extends Controller
{
    // Tampilkan semua pengaduan
    public function index()
    {
        $pengaduan = Pengaduan::latest()->get();
        return view('admin.report.index', compact('pengaduan'));
    }

    // Tampilkan form create
    public function create()
    {
        return view('admin.report.create');
    }

    // Simpan pengaduan baru
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required',
            'pelapor' => 'required|max:255',
        ]);

        $pengaduan = Pengaduan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pelapor' => $request->pelapor,
            'user_id' => Auth::id(),
            'status' => 'Diajukan',
        ]);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'keterangan' => 'Diajukan',
            'person' => $request->pelapor,
            'deskripsi' => 'Pengaduan baru dibuat',
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::with('logs')->findOrFail($id);
        return view('admin.report.detail', compact('pengaduan'));
    }

    // Validasi oleh kepala
    public function validasi($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Diproses']);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'keterangan' => 'Divalidasi',
            'person' => Auth::user()->name,
            'deskripsi' => 'Pengaduan divalidasi oleh Kepala Departemen',
        ]);

        return back()->with('success', 'Pengaduan berhasil divalidasi.');
    }

    // Approve oleh GM
    public function approve($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Disetujui']);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'keterangan' => 'Disetujui',
            'person' => Auth::user()->name,
            'deskripsi' => 'Pengaduan disetujui oleh Manager',
        ]);

        return back()->with('success', 'Pengaduan berhasil disetujui.');
    }

    // Tampilkan semua log
    public function showLogs($id)
    {
        $pengaduan = Pengaduan::with('logs')->findOrFail($id);
        return view('admin.report.logs.index', compact('pengaduan'));
    }

    // Tampilkan form tambah log
    public function createLog($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.report.logs.create', compact('pengaduan'));
    }

    // Simpan log
    public function storeLog(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'deskripsi' => 'required|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        PengaduanLog::create([
            'pengaduan_id' => $pengaduan->id,
            'keterangan' => $request->keterangan,
            'person' => Auth::user()->name,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('pengaduan.logs', $id)->with('success', 'Log berhasil ditambahkan.');
    }

    // Form edit log
    public function editLog($id, $logId)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $log = PengaduanLog::where('pengaduan_id', $id)->findOrFail($logId);

        return view('admin.report.logs.edit', compact('pengaduan', 'log'));
    }
}
