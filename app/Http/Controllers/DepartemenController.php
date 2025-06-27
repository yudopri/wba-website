<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::all();
        return view('admin.departemen.index', compact('departemens'));
    }

    public function create()
    {
        return view('admin.departemen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Departemen::create($request->all());
        return redirect()->route('admin.departemen.index')->with('success', 'Departemen created successfully.');
    }

    public function show($id)
    {
        $departemen = Departemen::find($id);
        return view('admin.departemen.show', compact('departemen'));
    }

    public function edit($id)
    {
        $departemen = Departemen::find($id);
        return view('admin.departemen.edit', compact('departemen'));
    }

    public function update(Request $request, Departemen $departemen)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $departemen->update($request->all());
        return redirect()->route('admin.departemen.index')->with('success', 'Departemen updated successfully.');
    }

 public function destroy($id)
{
    $departemen = Departemen::findOrFail($id);

    // Hapus departemen
    $departemen->delete();

    return redirect()->route('admin.departemen.index')->with('success', 'Departemen deleted successfully.');
}

}
