<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DokumenLokasi;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    public function index()
    {
        $dokumen = DokumenLokasi::latest()->get();
        return view('admin.dokumenlokasi.index', compact('dokumen'));
    }

    public function create()
    {
        return view('admin.dokumenlokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255',
            'nama_file' => 'required|string|max:255',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $file = $request->file('foto');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('dokumenlokasi', $fileName, 'public');

        DokumenLokasi::create([
            'nama_lokasi' => $request->nama_lokasi,
            'nama_file' => $request->nama_file,
            'file_path' => $path,
        ]);

        return redirect()->route('dokumenlokasi.index')->with('success', 'Foto berhasil diunggah.');
    }

    public function show($id)
    {
        $dokumen = DokumenLokasi::findOrFail($id);
        return view('admin.dokumenlokasi.show', compact('dokumen'));
    }

    public function destroy($id)
    {
        $dokumen = DokumenLokasi::findOrFail($id);
        Storage::disk('public')->delete($dokumen->file_path);
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
