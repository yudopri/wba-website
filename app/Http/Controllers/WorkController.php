<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    public function index()
    {
        $works = Work::paginate(10);
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


    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja deleted successfully.');
    }
}
