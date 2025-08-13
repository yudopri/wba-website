<?php

namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pengaduan;
use App\Models\PengaduanLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\NotificationUser;

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
            'kronologi' => 'required',
            'pelapor'   => 'required|max:255',
        ]);

        $pengaduan = Pengaduan::create([
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'pelapor'   => $request->pelapor,
            'kronologi' => $request->kronologi,
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

NotificationUser::create([
   'user_id' => Auth::id(),
    'tipe' => 'success',
    'judul' => 'Pengaduan Terkirim',
    'pesan' => 'Pengaduan "' . $pengaduan->judul . '" berhasil dikirim.',
    'sudah_dibaca' => 0,
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
            'kronologi'  => 'required|string',
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
    // Form upload bukti
public function formUploadBukti($id)
{
    $pengaduan = Pengaduan::findOrFail($id);
    return view('admin.report.upload_bukti', compact('pengaduan'));
}

// Simpan bukti ke storage
public function uploadBukti(Request $request, $id)
{
    $request->validate([
        'bukti' => 'required|image|mimes:jpg,png,jpeg|max:2048',
    ]);

    $pengaduan = Pengaduan::findOrFail($id);

    if ($request->hasFile('bukti')) {
        $file = $request->file('bukti');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Tentukan path folder
        $destinationPath = public_path('asset/bukti_laporan');

        // Buat folder jika belum ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        // Pindahkan file ke folder
        $file->move($destinationPath, $filename);

        // Simpan path relatif ke database
        $pengaduan->bukti_penyelesaian = 'asset/bukti_laporan/' . $filename;
        $pengaduan->save();
    }

    return redirect()->route('pengaduan.index')->with('success', 'Bukti berhasil diupload.');
}




public function printPDF($id)
{
    $pengaduan = Pengaduan::with('logs')->findOrFail($id);

    $pdf = Pdf::loadView('admin.report.laporan', compact('pengaduan'));

    return $pdf->stream('laporan_pengaduan_'.$pengaduan->id.'.pdf');
}


}
