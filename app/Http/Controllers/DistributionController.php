<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Distribution;
use App\Models\InventoryItem;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\NotificationUser;

class DistributionController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;
    $jenis  = $request->jenis; // ganti dari 'gada' ke 'jenis'

    $distributions = Distribution::with(['user', 'employee', 'inventoryItem'])
        ->when($search, function ($query, $search) {
            return $query->whereHas('employee', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%");
                })
                ->orWhereHas('inventoryItem', function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%");
                });
        })
        ->when($jenis, function ($query, $jenis) {
            return $query->whereHas('inventoryItem', function ($q) use ($jenis) {
                $q->where('jenis', $jenis);
            });
        })
        ->get();

    return view('admin.distributions.index', compact('distributions'));
}


    public function create()
    {
        $employees = Employee::all();
        $inventoryItems = InventoryItem::where('status', 'tersedia')->get();
        return view('admin.distributions.form', compact('employees', 'inventoryItems'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:employees,id',
            'id_inventori' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        // Kurangi stok InventoryItem
        $inventoryItem = InventoryItem::findOrFail($request->id_inventori);
        if ($inventoryItem->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak cukup'])->withInput();
        }
        $inventoryItem->stock -= $request->quantity;
        $inventoryItem->status = $inventoryItem->stock > 0 ? 'tersedia' : 'habis';
        $inventoryItem->save();

        Distribution::create([
            'id_user' => Auth::id(),
            'id_karyawan' => $request->id_karyawan,
            'id_inventori' => $request->id_inventori,
            'quantity' => $request->quantity,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.distributions.index')->with('success', 'Distribusi berhasil ditambahkan.');
    }

    public function show(Distribution $distribution)
    {
        $distribution->load(['user', 'employee', 'inventoryItem']);
        return view('admin.distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        $employees = Employee::all();
        $inventoryItems = InventoryItem::all();
        return view('admin.distributions.form', compact('distribution', 'employees', 'inventoryItems'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            'id_karyawan' => 'required|exists:employees,id',
            'id_inventori' => 'required|exists:inventory_items,id',
            'quantity' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
            'status' => 'required|string',
        ]);

        $inventoryItem = InventoryItem::findOrFail($request->id_inventori);

        // Kembalikan stok lama dulu
        $oldInventoryItem = InventoryItem::findOrFail($distribution->id_inventori);
        $oldInventoryItem->stock += $distribution->quantity;
        $oldInventoryItem->status = $oldInventoryItem->stock > 0 ? 'tersedia' : 'habis';
        $oldInventoryItem->save();

        // Kurangi stok baru
        if ($inventoryItem->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak cukup'])->withInput();
        }
        $inventoryItem->stock -= $request->quantity;
        $inventoryItem->status = $inventoryItem->stock > 0 ? 'tersedia' : 'habis';
        $inventoryItem->save();

        $distribution->update([
            'id_user' => Auth::id(),
            'id_karyawan' => $request->id_karyawan,
            'id_inventori' => $request->id_inventori,
            'quantity' => $request->quantity,
            'keterangan' => $request->keterangan,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.distributions.index')->with('success', 'Distribusi berhasil diperbarui.');
    }
public function upload(Request $request, $id)
{
    $distribution = Distribution::findOrFail($id);

    if ($request->hasFile('foto_bukti')) {
        $file = $request->file('foto_bukti');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan langsung ke public/assets/
        $file->move(public_path('assets/bukti_distribusi'), $filename);

        // Simpan path relatif ke database (biar bisa diakses pakai asset())
        $distribution->foto_bukti = 'assets/bukti_distribusi/' . $filename;
        $distribution->save();
    }

    return back()->with('success', 'Bukti berhasil diupload.');
}





    public function destroy(Distribution $distribution)
    {
        // Kembalikan stok
        $inventoryItem = InventoryItem::findOrFail($distribution->id_inventori);
        $inventoryItem->stock += $distribution->quantity;
        $inventoryItem->status = 'tersedia';
        $inventoryItem->save();

        $distribution->delete();

        return redirect()->route('admin.distributions.index')->with('success', 'Distribusi berhasil dihapus.');
    }

public function rekapDistribusi()
{
    \Log::info('rekapDistribusi() dipanggil oleh scheduler pada: ' . now());

    $employees = Employee::all();

    $belumDapat = $employees->filter(function ($emp) {
        return !Distribution::where('id_karyawan', $emp->id)
            ->whereHas('inventoryItem', function ($q) {
                $q->where('jenis_barang', 'seragam');
            })->exists();
    });

    $pdf = Pdf::loadView('admin.distributions.rekap_pdf', [
        'employees' => $belumDapat
    ]);

    $folder = public_path('assets/rekapseragam');
    if (!file_exists($folder)) mkdir($folder, 0755, true);

    $filename = 'rekap_seragam_' . now()->format('Y_m') . '.pdf';
    $pdf->save($folder.'/'.$filename);

    NotificationUser::create([
        'user_id' => 3,
        'judul' => 'Rekap Distribusi',
        'pesan' => 'Rekap distribusi seragam 6 bulan tersedia',
        'sudah_dibaca' => false,
    ]);

    \Log::info("Notifikasi rekap dibuat, file: {$filename}");
}



public function daftarRekap()
{
    $folder = public_path('assets/rekapseragam');

    $fileNames = [];
    if(file_exists($folder)) {
        $files = File::files($folder);
        foreach($files as $file){
            $fileNames[] = $file->getFilename();
        }
    }

    return view('admin.distributions.rekapseragam', compact('fileNames'));
}



}
