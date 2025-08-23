<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    public function index(Request $request)
{
    $query = Work::query();

    // 🔍 Filter Nama Perusahaan
    if ($request->filled('nama_perusahaan')) {
        $query->where('name', 'like', '%' . $request->nama_perusahaan . '%');
    }

    // ✅ Filter langsung ke kolom status
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // Pagination dengan query tetap terbawa
    $works = $query->paginate(10)->appends($request->query());

    return view('admin.work.index', compact('works'));
}



    public function create()
    {
        $work = Work::all();
        return view('admin.work.create', compact('work'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'berlaku' => 'nullable|date',
        'pict_dokumen' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'pict_dokumen1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'pict_dokumen2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'status' => 'nullable|in:aktif,nonaktif',
    ]);

    if (!isset($validated['status'])) {
        $validated['status'] = 'aktif';
    }


    if ($request->hasFile('pict_dokumen')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName = time() . '_' . $request->file('pict_dokumen')->getClientOriginalName();
        $request->file('pict_dokumen')->move($directory, $fileName);

        $validated['pict_dokumen'] = 'assets/berkasdokumen/' . $fileName;
    }
    if ($request->hasFile('pict_dokumen1')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName1 = time() . '_' . $request->file('pict_dokumen1')->getClientOriginalName();
        $request->file('pict_dokumen1')->move($directory, $fileName1);

        $validated['pict_dokumen1'] = 'assets/berkasdokumen/' . $fileName1;
    }
    if ($request->hasFile('pict_dokumen2')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName2 = time() . '_' . $request->file('pict_dokumen2')->getClientOriginalName();
        $request->file('pict_dokumen2')->move($directory, $fileName2);
        $validated['pict_dokumen2'] = 'assets/berkasdokumen/' . $fileName2;
    }

    Work::create($validated);

    return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja created successfully.');
}

    public function show($id)
    {
        $work = Work::find($id);
        return view('admin.work.show', compact('work'));
    }

    public function edit($id)
    {
        $work = Work::find($id);
        return view('admin.work.edit', compact('work'));
    }

    public function update(Request $request, Work $work)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'berlaku' => 'nullable|date',
        'pict_dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'pict_dokumen1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'pict_dokumen2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        'status' => 'nullable|in:aktif,nonaktif',
    ]);

    if (!isset($validated['status'])) {
        $validated['status'] = 'aktif';
    }


    if ($request->hasFile('pict_dokumen')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName = time() . '_' . $request->file('pict_dokumen')->getClientOriginalName();
        $request->file('pict_dokumen')->move($directory, $fileName);

        $validated['pict_dokumen'] = 'assets/berkasdokumen/' . $fileName;
    }
    if ($request->hasFile('pict_dokumen1')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName1 = time() . '_' . $request->file('pict_dokumen1')->getClientOriginalName();
        $request->file('pict_dokumen1')->move($directory, $fileName1);

        $validated['pict_dokumen1'] = 'assets/berkasdokumen/' . $fileName1;
    }
    if ($request->hasFile('pict_dokumen2')) {
        $directory = public_path('assets/berkasdokumen');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        $fileName2 = time() . '_' . $request->file('pict_dokumen2')->getClientOriginalName();
        $request->file('pict_dokumen2')->move($directory, $fileName2);
        $validated['pict_dokumen2'] = 'assets/berkasdokumen/' . $fileName2;
    }

    $work->update($validated);

    return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja updated successfully.');
}
public function aktif($id)
    {
        try {
            $Work = Work::findOrFail($id);
            Log::info("Attempting to update status to 'aktif' for Work ID: $id");

            // Pastikan status hanya diubah menjadi 'aktif'
            if ($Work->status !== 'aktif') {
                $Work->update(['status' => 'aktif']);
                Log::info("Status kerja successfully updated to 'aktif' for Work ID: $id");
            }

            return redirect()->route('admin.work.index')->with('success', 'Status kerja karyawan berhasil diperbarui menjadi aktif.');
        } catch (\Exception $e) {
            Log::error("Failed to update status to 'aktif' for Work ID: $id", [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.work.index')->with('error', 'Gagal memperbarui status kerja karyawan.');
        }
    }

    public function nonaktif($id)
    {
        try {
            $Work = Work::findOrFail($id);
            Log::info("Attempting to update status to 'nonaktif' for Work ID: $id");

            // Pastikan status hanya diubah menjadi 'nonaktif'
            if ($Work->status !== 'nonaktif') {
                $Work->update(['status' => 'nonaktif']);
                Log::info("Status kerja successfully updated to 'nonaktif' for Work ID: $id");
            }

            return redirect()->route('admin.work.index')->with('success', 'Status kerja karyawan berhasil diperbarui menjadi nonaktif.');
        } catch (\Exception $e) {
            Log::error("Failed to update status to 'nonaktif' for Work ID: $id", [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.work.index')->with('error', 'Gagal memperbarui status kerja karyawan.');
        }
    }

    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja deleted successfully.');
    }
}
