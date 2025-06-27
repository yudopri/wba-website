<?php

namespace App\Http\Controllers;

use App\Models\Gada;
use Illuminate\Http\Request;

class GadaController extends Controller
{
    public function index()
{
    $gadas = Gada::paginate(10);  // Paginate the results (10 items per page)
    return view('admin.gada.index', compact('gadas'));
}
    public function create()
    {
        return view('admin.gada.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Gada::create($request->all());
        return redirect()->route('admin.gada.index')->with('success', 'Gada created successfully.');
    }

    public function show($id)
    {
        $gada = Gada::find($id);
        return view('admin.gada.show', compact('gada'));
    }

    public function edit($id)
    {
        $gada = Gada::find($id);
        return view('admin.gada.edit', compact('gada'));
    }

    public function update(Request $request, Gada $gada)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $gada->update($request->all());
        return redirect()->route('admin.gada.index')->with('success', 'Gada updated successfully.');
    }

    public function destroy(Gada $gada)
    {
        $gada->delete();
        return redirect()->route('admin.gada.index')->with('success', 'Gada deleted successfully.');
    }
}
