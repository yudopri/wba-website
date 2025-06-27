<?php

namespace App\Http\Controllers;

use App\Models\Work;
use Illuminate\Http\Request;

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
        $request->validate([
            'name' => 'required|string|max:255',
            'berlaku' => 'nullable|date',
        ]);

        Work::create($request->all());
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
        $request->validate([
            'name' => 'required|string|max:255',
            'berlaku' => 'nullable|date',
        ]);

        $work->update($request->all());
        return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja updated successfully.');
    }

    public function destroy(Work $work)
    {
        $work->delete();
        return redirect()->route('admin.work.index')->with('success', 'Lokasi Kerja deleted successfully.');
    }
}
