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
        $pengaduan = Pengaduan::with('user')->orderBy('created_at', 'desc')->get();
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
            'judul'     => 'required|max:255',
            'deskripsi' => 'required',
            'pelapor'   => 'required|max:255',
        ]);

        $pengaduan = Pengaduan::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pelapor'   => $request->pelapor,
            'id_user'   => Auth::id(),
            'status'    => 'Diajukan',
        ]);

        PengaduanLog::create([
            'id_complaint' => $pengaduan->id,
            'id_user'      => Auth::id(),
            'status'       => 'Diajukan',
            'keterangan'   => 'Pengaduan diajukan oleh pelapor',
            'approved_at'  => now(),
        ]);

        return redirect()->route('pengaduan.index')->with('success', 'Pengaduan berhasil dikirim.');
    }

    // Detail pengaduan
    public function show($id)
    {
        $pengaduan = Pengaduan::with('logs')->findOrFail($id);
        return view('admin.report.detail', compact('pengaduan'));
    }

    // Validasi oleh Kepala
    public function validasi($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Diproses']);

        PengaduanLog::create([
            'id_complaint' => $pengaduan->id,
            'id_user'      => Auth::id(),
            'status'       => 'Diproses',
            'keterangan'   => 'Pengaduan divalidasi oleh Kepala Departemen',
            'approved_at'  => now(),
        ]);

        return back()->with('success', 'Pengaduan berhasil divalidasi.');
    }

    // Approve oleh Manager
    public function approve($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $pengaduan->update(['status' => 'Disetujui']);

        PengaduanLog::create([
            'id_complaint' => $pengaduan->id,
            'id_user'      => Auth::id(),
            'status'       => 'Disetujui',
            'keterangan'   => 'Pengaduan disetujui oleh Manager',
            'approved_at'  => now(),
        ]);

        return redirect()->back()->with('success', 'Pengaduan berhasil disetujui.');
    }

    // Semua log dari pengaduan
    public function showLogs($id)
    {
        $pengaduan = Pengaduan::with('logs')->findOrFail($id);
        return view('admin.report.logs.index', compact('pengaduan'));
    }

    // Form tambah log
    public function createLog($id)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        return view('admin.report.logs.create', compact('pengaduan'));
    }

    // Simpan log tambahan
    public function storeLog(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string',
            'deskripsi'  => 'required|string',
        ]);

        $pengaduan = Pengaduan::findOrFail($id);

        PengaduanLog::create([
            'id_complaint' => $pengaduan->id,
            'id_user'      => Auth::id(),
            'status'       => $pengaduan->status,
            'keterangan'   => $request->keterangan,
            'approved_at'  => now(),
        ]);

        return redirect()->route('pengaduan.logs', $id)->with('success', 'Log berhasil ditambahkan.');
    }

    // Edit log
    public function editLog($id, $logId)
    {
        $pengaduan = Pengaduan::findOrFail($id);
        $log = PengaduanLog::where('id_complaint', $id)->findOrFail($logId);

        return view('admin.report.logs.edit', compact('pengaduan', 'log'));
    }
}
