<?php

namespace App\Http\Controllers;

use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $search = $request->search;
    $type = $request->jenis; // dari form <select>

    $inventoryItems = InventoryItem::when($search, function ($query, $search) {
            return $query->where('nama', 'like', '%' . $search . '%');
        })
        ->when($type, function ($query, $type) {
            return $query->where('jenis', $type);
        })
        ->get();

    return view('admin.inventory.index', compact('inventoryItems'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.inventory.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'jenis' => 'required|string|in:Alat,Seragam',
        'price' => 'required|numeric|min:0',
    ]);

    // Cari apakah barang dengan nama yang sama sudah ada
    $existingItem = InventoryItem::where('nama_barang', $request->nama)->first();

    if ($existingItem) {
        // Tambah quantity ke stock
        $newStock = $existingItem->stock + $request->quantity;
        $existingItem->update([
            'quantity' => $existingItem->quantity + $request->quantity,
            'stock'    => $newStock,
            'price'    => $request->price,
            'status'   => $newStock > 0 ? 'tersedia' : 'habis',
        ]);
    } else {
        // Buat data baru
        InventoryItem::create([
            'nama_barang'  => $request->nama,
            'quantity'     => $request->quantity,
            'jenis_barang' => $request->jenis,
            'stock'        => $request->quantity,
            'price'        => $request->price,
            'status'       => $request->quantity > 0 ? 'tersedia' : 'habis',
            'id_user'      => Auth::id(),
        ]);
    }

    return redirect()->route('admin.inventory.index')->with('success', 'Barang berhasil ditambahkan.');
}


    /**
     * Display the specified resource.
     */
    public function show(InventoryItem $inventoryItem)
    {
        return view('admin.inventory.show', compact('inventoryItem'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InventoryItem $inventoryItem)
    {
        return view('admin.inventory.form', compact('inventoryItem'));
    }

    /**
     * Update the specified resource in storage.
     */
  public function update(Request $request, InventoryItem $inventoryItem)
{
    // Validasi input
    $request->validate([
        'nama' => 'required|string|max:255',
        'quantity' => 'required|integer|min:1',
        'jenis' => 'required|string|in:Alat,Seragam',
        'price' => 'required|numeric|min:0',
    ]);

    $inventoryItem->update([
        'nama_barang'  => $request->nama,
        'quantity'     => $request->quantity,
        'jenis_barang' => $request->jenis,
        'stock'        => $request->quantity,
        'price'        => $request->price,
        'status'       => $request->quantity > 0 ? 'tersedia' : 'habis',
        'id_user'      => Auth::id(),
    ]);

    return redirect()->route('admin.inventory.index')->with('success', 'Barang berhasil diperbarui.');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InventoryItem $inventoryItem)
    {
        // Hapus data barang
        $inventoryItem->delete();

        return redirect()->route('admin.inventory.index')->with('success', 'Barang berhasil dihapus.');
    }
}
