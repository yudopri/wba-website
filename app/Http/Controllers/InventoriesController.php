<?php

namespace App\Http\Controllers;

use App\Models\Inventories;
use App\Models\InventoryItem;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InventoriesController extends Controller
{
    // Menampilkan daftar barang yang dipinjamkan
    public function index(Request $request)
{
    $query = Inventories::with(['inventoryItem', 'employee', 'user']);

    // Filter berdasarkan pencarian nama karyawan atau barang
    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('employee', function ($q) use ($search) {
            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nik', 'like', "%{$search}%");
        })
        ->orWhereHas('inventoryItem', function ($q) use ($search) {
            $q->where('nama_barang', 'like', "%{$search}%");
        });
    }

    // Filter berdasarkan jenis barang
    if ($request->filled('jenis_barang')) {
        $jenis = $request->jenis_barang;
        $query->whereHas('inventoryItem', function ($q) use ($jenis) {
            $q->where('jenis_barang', $jenis);
        });
    }

    $inventories = $query->get();

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
   public function edit($id)
{
    $inventory = Inventories::findOrFail($id);
     $employees = Employee::all();
    $inventoryItems = InventoryItem::all();
    return view('admin.inventaris.form', compact('inventory', 'employees', 'inventoryItems'));
}


    // Update peminjaman
    public function update(Request $request, Inventories $inventory)
{
    $request->validate([
        'id_karyawan' => 'required',
        'id_inventori' => 'required',
        'quantity' => 'required|integer|min:1',
        'status' => 'required',
    ]);

    $inventoryItem = InventoryItem::findOrFail($request->id_inventori);

    // Hitung stok baru (kembalikan stok lama, kurangi stok baru)
    $stokBaru = $inventoryItem->stock + $inventory->quantity - $request->quantity;

    // Update data peminjaman
    $inventory->update([
        'id_user' => Auth::id(),
        'id_karyawan' => $request->id_karyawan,
        'id_inventori' => $request->id_inventori,
        'quantity' => $request->quantity,
        'status' => $request->status,
        'keterangan' => $request->keterangan ?? null,
    ]);

    // Update stok item
    $inventoryItem->stock = $stokBaru;
    $inventoryItem->status = $stokBaru > 0 ? 'tersedia' : 'habis';
    $inventoryItem->save();

    return redirect()->route('admin.inventaris.index')
        ->with('success', 'Data inventaris berhasil diperbarui');
}

public function upload(Request $request, $id)
{
    $inventory = Inventories::findOrFail($id);

    $request->validate([
        'foto_bukti' => 'required|image|max:2048', // maksimal 2MB
    ]);

    if ($request->hasFile('foto_bukti')) {
        $file = $request->file('foto_bukti');

        $filename = time() . '_' . $file->getClientOriginalName();

        $destinationPath = public_path('assets/bukti_inventori');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        // Simpan path relatif untuk akses dengan asset()
        $inventory->foto_bukti = 'assets/bukti_inventori/' . $filename;
        // Update status jadi 'Selesai'
        $inventory->status = 'Sudah Kembali';
        $inventory->save();

        return back()->with('success', 'Bukti berhasil diupload.');
    }

    return back()->withErrors(['foto_bukti' => 'File tidak valid atau tidak ditemukan.']);
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
