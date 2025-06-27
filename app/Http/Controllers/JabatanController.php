<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    public function create()
    {
        return view('admin.jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Jabatan::create($request->all());
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan created successfully.');
    }

    public function show($id)
    {
        $jabatan = Jabatan::find($id);
        return view('admin.jabatan.show', compact('jabatan'));
    }

    public function edit($id)
    {
        $jabatan = Jabatan::find($id);
        return view('admin.jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $jabatan->update($request->all());
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan updated successfully.');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('admin.jabatan.index')->with('success', 'Jabatan deleted successfully.');
    }
}
