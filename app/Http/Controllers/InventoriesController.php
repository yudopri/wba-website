<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use App\Models\InventoryItem;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoriesController extends Controller
{
    // Menampilkan daftar barang yang dipinjamkan
    public function index()
    {
        $inventories = Inventories::with(['inventoryItem', 'employee', 'user'])->get();
        return view('admin.inventaris.index', compact('inventories'));
    }

    // Menampilkan form untuk meminjam barang (create)
    public function create()
    {
        $inventoryItems = InventoryItem::where('status', 'tersedia')->get(); // Barang yang tersedia untuk dipinjam
        $employees = Employee::all(); // Semua karyawan
        return view('admin.inventaris.form', compact('inventoryItems', 'employees'));
    }

    // Menyimpan peminjaman barang
   public function store(Request $request)
{
    $request->validate([
        // 'id_user' => 'required', // hapus ini
        'id_karyawan' => 'required',
        'id_inventori' => 'required',
        'quantity' => 'required|integer|min:1',
        'status' => 'required',
    ]);

    // Buat data peminjaman dengan id_user otomatis dari user login
    $peminjaman = Inventories::create([
        'id_user' => Auth::id(),
        'id_karyawan' => $request->id_karyawan,
        'id_inventori' => $request->id_inventori,
        'quantity' => $request->quantity,
        'status' => $request->status,
        'keterangan' => $request->keterangan ?? null, // jika ada kolom keterangan
    ]);

    // Kurangi stok di InventoryItem
    $inventoryItem = InventoryItem::findOrFail($request->id_inventori);
    $inventoryItem->stock -= $request->quantity;

    // Update status barang
    $inventoryItem->status = $inventoryItem->stock > 0 ? 'tersedia' : 'habis';
    $inventoryItem->save();

    return redirect()->route('admin.inventaris.index');
}

    // Menampilkan detail barang yang dipinjam
    public function show(Inventories $inventory)
    {
        return view('admin.inventaris.show', compact('inventory'));
    }

    // Menampilkan form untuk edit peminjaman
    public function edit(Inventories $inventory)
    {
        $inventoryItems = InventoryItem::all(); // Semua barang di gudang
        $employees = Employee::all(); // Semua karyawan
        return view('admin.inventaris.form', compact('inventory', 'inventoryItems', 'employees'));
    }

    // Update peminjaman
    public function update(Request $request, Inventories $inventory)
{
    $request->validate([
        // 'id_user' => 'required', // hapus ini
        'id_karyawan' => 'required',
        'id_inventori' => 'required',
        'quantity' => 'required|integer|min:1',
        'status' => 'required',
    ]);

    $inventoryItem = InventoryItem::findOrFail($request->id_inventori);

    // Kembalikan jumlah lama ke stok
    $inventoryItem->stock += $inventory->quantity;

    // Update data peminjaman dengan id_user otomatis dari user login
    $inventory->update([
        'id_user' => Auth::id(),
        'id_karyawan' => $request->id_karyawan,
        'id_inventori' => $request->id_inventori,
        'quantity' => $request->quantity,
        'status' => $request->status,
        'keterangan' => $request->keterangan ?? null,
    ]);

    // Kurangi stok dengan jumlah baru
    $inventoryItem->stock -= $request->quantity;
    $inventoryItem->status = $inventoryItem->stock > 0 ? 'tersedia' : 'habis';
    $inventoryItem->save();

    return redirect()->route('admin.inventaris.index');
}


    // Menghapus peminjaman
   public function destroy(Inventories $inventory)
{
    // Kembalikan jumlah barang ke gudang
    $inventoryItem = $inventory->inventoryItem;
    $inventoryItem->stock += $inventory->quantity;
    $inventoryItem->status = 'tersedia';
    $inventoryItem->save();

    // Hapus data peminjaman
    $inventory->delete();

    return redirect()->route('admin.inventaris.index');
}

}
