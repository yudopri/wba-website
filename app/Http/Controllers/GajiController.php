<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gaji;
use App\Models\GajiLog;
use App\Models\Partner;
use Illuminate\Support\Facades\Auth;

class GajiController extends Controller
{
    public function index(Request $request)
    {
        $query = Gaji::with(['partner', 'user']);

        if ($request->filled('bulan')) {
            $bulan = date('m', strtotime("1 " . $request->gada));
            $query->whereMonth('bulan', $bulan);
        }

        $dataGaji = $query->latest()->get();

        return view('admin.gaji.index', compact('dataGaji'));
    }

    public function create()
    {
        $partners = Partner::all();
        return view('admin.gaji.create', compact('partners'));
    }

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

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil disimpan.');
    }

    public function show($id)
    {
        $gaji = Gaji::with(['partner', 'user', 'logs'])->findOrFail($id);
        return view('admin.gaji.detail', compact('gaji'));
    }

    public function konfirmasi($id)
    {
        $gaji = Gaji::findOrFail($id);

        $gaji->logs()->create([
            'keterangan' => 'Dikonfirmasi',
            'person'     => Auth::user()->name ?? 'System',
            'deskripsi'  => 'Data penggajian telah dikonfirmasi.',
        ]);

        return back()->with('success', 'Data gaji berhasil dikonfirmasi.');
    }
}
