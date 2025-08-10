<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiLog;
<<<<<<< HEAD
=======
use App\Models\Partner;
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index(Request $request)
<<<<<<< HEAD
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
=======
    {
        $query = Gaji::with(['partner', 'user']);

        if ($request->has('gada') && $request->gada != '') {
            $bulan = date('m', strtotime("1 " . $request->gada));
            $query->whereMonth('bulan', $bulan);
        }

        $dataGaji = $query->latest()->get();

        return view('admin.gaji.index', compact('dataGaji'));
    }

>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
    public function create()
    {
        $partners = Partner::all();
        return view('admin.gaji.create', compact('partners'));
    }

<<<<<<< HEAD
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
=======
    public function store(Request $request)
    {
        $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'nominal'    => 'required|numeric',
            'bulan'      => 'required|date_format:Y-m',
        ]);

        $gaji = Gaji::create([
            'partner_id' => $request->partner_id,
            'id_user'    => Auth::id(),
            'nominal'    => $request->nominal,
            'bulan'      => $request->bulan . '-01',
        ]);

        $gaji->logs()->create([
            'keterangan' => 'Data dibuat',
            'person'     => Auth::user()->name ?? 'System',
            'deskripsi'  => 'Data penggajian berhasil ditambahkan.',
        ]);
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60


    public function show($id)
    {
        $gaji = Gaji::with(['partner', 'user', 'logs'])->findOrFail($id);
        return view('admin.gaji.detail', compact('gaji'));
       $gaji = Gaji::with(['karyawan', 'user', 'logs'])->findOrFail($id);


    }

<<<<<<< HEAD
    // Konfirmasi gaji (jika Anda ingin tetap punya status, harus tambahkan kolom status di tabel salaries)
=======
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
    public function konfirmasi($id)
    {
        $gaji = Gaji::findOrFail($id);

<<<<<<< HEAD
        // Jika kolom `status` sudah dihapus, bagian ini akan error. Bisa dihapus atau dibiarkan jika Anda ingin menambahkan kembali kolom `status`.
        // $gaji->update(['status' => 'Dikonfirmasi']);

=======
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
        $gaji->logs()->create([
            'keterangan' => 'Dikonfirmasi',
            'person'     => Auth::user()->name ?? 'System',
            'deskripsi'  => 'Data penggajian telah dikonfirmasi.',
        ]);

        return back()->with('success', 'Data gaji berhasil dikonfirmasi.');
    }

}
