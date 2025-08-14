<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Gada;
use App\Models\GadaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;
use App\Models\Blacklist;
use App\Models\Work;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Cell\DataType; // Namespace untuk DataType
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Exports\EmployeeExport;
use App\Imports\EmployeeImport;


class EmployeeController extends Controller
{
    // Menampilkan daftar employee dengan pencarian dan filter
    public function index(Request $request)
{
    $query = Employee::query();

    // Filter untuk karyawan biasa (hanya data dirinya sendiri)
    if (auth()->user()->role === 'Karyawan') {
        $query->where(function ($subQuery) {
            $subQuery->where('name', auth()->user()->name)
                     ->orWhere('email', auth()->user()->email);
        });
    }

    // Filter berdasarkan pencarian
    if ($request->filled('search')) {
    $search = $request->search;

    $query->where(function ($subQuery) use ($search) {
        $subQuery->where('name', 'like', '%' . $search . '%')
                 ->orWhere(function ($innerQuery) use ($search) {
                     $employees = Employee::all(); // Ambil semua data dari tabel

                     $filteredIds = $employees->filter(function ($employee) use ($search) {
                         try {
                             $nik = Crypt::decryptString($employee->nik);
                             $nikKtp = Crypt::decryptString($employee->nik_ktp);
                         } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
                             return false; // Lewati data jika gagal didekripsi
                         }

                         return strpos($nik, $search) !== false ||
                                strpos($nikKtp, $search) !== false;
                     })->pluck('id'); // Ambil ID yang cocok

                     if ($filteredIds->isNotEmpty()) {
                         $innerQuery->whereIn('id', $filteredIds);
                     }
                 });
    });
}


    // Filter berdasarkan departemen
    if ($request->filled('departemen_id')) {
        $query->where('departemen_id', $request->departemen_id);
    }

    // Filter berdasarkan jabatan
    if ($request->filled('jabatan_id')) {
        $query->where('jabatan_id', $request->jabatan_id);
    }

    // Filter berdasarkan gada_id di GadaDetail
    if ($request->filled('gada')) {
        $query->whereHas('gadadetail', function ($subQuery) use ($request) {
            $subQuery->where('gada_id', $request->gada);
        });
    }

    // Filter berdasarkan lokasi kerja
    if ($request->filled('lokasikerja')) {
        $query->where('lokasikerja', $request->lokasikerja);
    }
    if ($request->filled('status_kepegawaian')) {
        $query->where('status_kepegawaian', $request->status_kepegawaian);
    }
    // Filter berdasarkan status kerja
    if ($request->filled('status')) {
        $query->where('status_kerja', $request->status);
    }

    // Prioritaskan status kerja: aktif di atas, blacklist di bawah
    $query->orderByRaw("FIELD(status_kerja, 'aktif') DESC")
          ->orderByRaw("FIELD(status_kerja, 'blacklist') ASC");

    // Paginate hasil
    $employees = $query->paginate(15);

    // Data tambahan untuk filter
    $departemens = Departemen::all();
    $jabatans = Jabatan::all();
    $gadas = Gada::all();
    $gadadetail = GadaDetail::all();
    $works = Work::all();

    return view('admin.employee.index', compact('employees', 'departemens', 'jabatans', 'gadas', 'gadadetail', 'works'));
}



    // Menampilkan form tambah employee
    public function create()
    {
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        $gadas = Gada::all();
        $works = Work::all();
        $jabatanStaff = Jabatan::where('name', 'like', 'Staff%')->get();

        return view('admin.employee.create', compact('departemens', 'jabatans', 'gadas','works', 'jabatanStaff'));
    }

    // Menyimpan data employee baru
  public function store(Request $request)
{
    // Validasi awal
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'pict_diri' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nik' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'departemen_id' => 'required|exists:departemens,id',
        'jabatan_id' => 'required|exists:jabatans,id',
        'pict_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'keterangan' => 'nullable|string',
        'tmt' => 'nullable|date',
        'tempat_lahir' => 'nullable|string',
        'ttl' => 'nullable|date',
        'telp' => 'nullable|string',
        'nik_ktp' => 'nullable|string|max:255',
        'pict_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status_kepegawaian' => 'nullable|string',
        'berlaku' => 'nullable|date',
        'status' => 'nullable|string',
        'pendidikan' => 'nullable|string',
        'pict_ijasah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nama_ibu' => 'nullable|string',
        'nama_pasangan' => 'nullable|string',
        'tempatlahir_pasangan' => 'nullable|string',
        'ttl_pasangan' => 'nullable|date',
        'nama_anak1' => 'nullable|string',
        'tempatlahir_anak1' => 'nullable|string',
        'ttl_anak1' => 'nullable|date',
        'nama_anak2' => 'nullable|string',
        'tempatlahir_anak2' => 'nullable|string',
        'ttl_anak2' => 'nullable|date',
        'nama_anak3' => 'nullable|string',
        'tempatlahir_anak3' => 'nullable|string',
        'ttl_anak3' => 'nullable|date',
        'no_regkta' => 'nullable|string|max:255',
        'pict_kta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'alamat_ktp' => 'nullable|string',
        'alamat_domisili' => 'nullable|string',
        'bpjsket' => 'nullable|string',
        'pict_bpjsket' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'no_npwp' => 'nullable|string',
        'pict_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'bpjskes' => 'nullable|string',
        'pict_bpjskes' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status_kerja' => 'nullable|string',
        'pict_jobapp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_pkwt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'gada_id1' => 'nullable|string',
        'gada_id2' => 'nullable|string',
        'gada_id3' => 'nullable|string',
        'gada_id1_other_text' => 'nullable|string',
        'gada_id2_other_text' => 'nullable|string',
        'gada_id3_other_text' => 'nullable|string',
        'lokasikerja' => 'nullable|string',
        'uk_sepatu' => 'nullable|string',
        'uk_seragam' => 'nullable|string',
    ]);

  // Pemeriksaan duplikasi NIK KTP, email, dan nama
   // Pertama, cek apakah NIK KTP, Email, atau Nama sudah terdaftar
$existingEmployee = Employee::query()
    ->get() // Ambil semua data
    ->first(function ($employee) use ($validatedData) {
        try {
            // Dekripsi nik_ktp dan nik
            $decryptedNikKtp = Crypt::decryptString($employee->nik_ktp);
            $decryptedNik = Crypt::decryptString($employee->nik);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan, set nilai null
            $decryptedNikKtp = null;
            $decryptedNik = null;
        }

        // Periksa kecocokan nik_ktp, nik, atau email
        return ($decryptedNikKtp === $validatedData['nik_ktp'] ||
                $decryptedNik === $validatedData['nik'] ||
                $employee->email === $validatedData['email']);
    });


if ($existingEmployee) {
    // Periksa apakah employee_id ada di tabel blacklist
    $isBlacklisted = DB::table('blacklists')
        ->where('employee_id', $existingEmployee->id)
        ->exists();

    if ($isBlacklisted) {
        return redirect()->back()->withErrors(['nik_ktp' => 'Data karyawan ini ditemukan dalam daftar blacklist.']);
    }

    return redirect()->back()->withErrors(['error' => 'Data telah terdaftar sebelumnya.']);
}


    // Enkripsi data sensitif
    $encryptedFields = ['nik', 'nik_ktp', 'no_regkta', 'nama_ibu','nama_pasangan','nama_anak1','nama_anak2','nama_anak3', 'alamat_ktp', 'alamat_domisili', 'bpjsket', 'telp', 'no_npwp', 'bpjskes'];
    foreach ($encryptedFields as $field) {
        if (!empty($validatedData[$field])) {
            $validatedData[$field] = Crypt::encryptString($validatedData[$field]);
        }
    }

    // Penanganan file

    $fileFields =  ['pict_diri','pict_sertifikat','pict_sertifikat1','pict_sertifikat2','pict_sertifikat3', 'pict_ktp','pict_kk', 'pict_kta', 'pict_npwp', 'pict_bpjsket', 'pict_bpjskes', 'pict_ijasah','pict_jobapp','pict_pkwt'];
    foreach ($fileFields as $fileField) {
        if ($request->hasFile($fileField)) {
             // Tentukan path penyimpanan file
                $directory = public_path('assets/berkas');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file($fileField)->getClientOriginalName();
                $filePath = 'assets/berkas/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file($fileField)->move($directory, $filePath);

                // Simpan path file ke array data
                $validatedData[$fileField] = $filePath;
        }
    }

    // Pastikan Gada ada atau buat jika belum ada
$gadaIds = ['gada_id1', 'gada_id2', 'gada_id3'];
foreach ($gadaIds as $gadaId) {
    // Jika memilih opsi "lainnya", buat entry baru
    if ($validatedData[$gadaId] == 'other') {
        $gadaName = $validatedData[$gadaId . '_other_text'];

        // Pastikan teks lainnya tidak kosong
        if ($gadaName) {
            $validatedData[$gadaId] = Gada::firstOrCreate(['name' => $gadaName])->id;
        } else {
            return redirect()->back()->withErrors(['error' => 'Nama untuk opsi lainnya harus diisi.']);
        }
    } else {
        // Validasi dan ambil ID Gada dari DB
        if (!empty($validatedData[$gadaId])) {
            $gada = Gada::find($validatedData[$gadaId]);
            if ($gada) {
                $validatedData[$gadaId] = $gada->id;
            } else {
                return redirect()->back()->withErrors(['error' => 'ID Gada tidak valid.']);
            }
        } else {
            // Jika gada_id kosong, set sebagai null
            $validatedData[$gadaId] = null;
        }
    }
}

// Gunakan transaksi database
DB::beginTransaction();

try {

    $employee = Employee::create($validatedData);

    // Simpan detail Gada hanya jika gada_id tidak null
    foreach (['gada_id1', 'gada_id2', 'gada_id3'] as $gadaId) {
        if ($validatedData[$gadaId]) {
            GadaDetail::create([
                'employee_id' => $employee->id,
                'gada_id' => $validatedData[$gadaId],
            ]);
        }
    }

    // Commit transaksi
    DB::commit();

    return redirect()->route('admin.employee.index')->with('success', 'Karyawan berhasil ditambahkan dengan status aktif.');
} catch (\Exception $e) {
    // Rollback transaksi jika terjadi error
    DB::rollBack();
    return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
}

}


    // Menampilkan detail employee
     public function show($id)
    {
        $employee = Employee::with(['departemen', 'jabatan', 'gadadetail','partner'])->findOrFail($id);
        return view('admin.employee.show', compact('employee'));
    }

    // Menampilkan form edit employee
    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        $departemens = Departemen::all();
        $jabatans = Jabatan::all();
        $gadas = Gada::all();
        $works = Work::all();
    $gadadetail = GadaDetail::all();
    $jabatanStaff = Jabatan::where('name', 'like', 'Staff%')->get();
        return view('admin.employee.edit', compact('employee', 'departemens', 'jabatans', 'gadas','works','gadadetail', 'jabatanStaff'));
    }

    // Menghapus employee
    public function destroy(Employee $employee)
    {
        // Hapus file sertifikat terkait jika ada
        if ($employee->sertifikat) {
            Storage::delete('public/sertificates/' . $employee->sertifikat);
        }

        $employee->delete();

        return redirect()->route('admin.employee.index')->with('success', 'Employee deleted successfully.');
    }
    // Update employee data
  public function update(Request $request, Employee $employee)
{

    // Validasi data
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'pict_diri' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nik' => 'required|string|unique:employees,nik,' . $employee->id,
        'email' => 'required|email|unique:employees,email,' . $employee->id,
        'departemen_id' => 'required|exists:departemens,id',
        'jabatan_id' => 'required|exists:jabatans,id',
        'pict_sertifikat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat1' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat2' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_sertifikat3' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'keterangan' => 'nullable|string',
        'tmt' => 'nullable|date',
        'tempat_lahir' => 'nullable|string',
        'ttl' => 'nullable|date',
        'telp' => 'nullable|string',
        'nik_ktp' => 'nullable|string',
        'pict_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status_kepegawaian' => 'nullable|string',
        'berlaku' => 'nullable|date',
        'status' => 'nullable|string',
        'pendidikan' => 'nullable|string',
        'pict_ijasah' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'nama_ibu' => 'nullable|string',
        'nama_pasangan' => 'nullable|string',
        'tempatlahir_pasangan' => 'nullable|string',
        'ttl_pasangan' => 'nullable|date',
        'nama_anak1' => 'nullable|string',
        'tempatlahir_anak1' => 'nullable|string',
        'ttl_anak1' => 'nullable|date',
        'nama_anak2' => 'nullable|string',
        'tempatlahir_anak2' => 'nullable|string',
        'ttl_anak2' => 'nullable|date',
        'nama_anak3' => 'nullable|string',
        'tempatlahir_anak3' => 'nullable|string',
        'ttl_anak3' => 'nullable|date',
        'no_regkta' => 'nullable|string',
        'pict_kta' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'alamat_ktp' => 'nullable|string',
        'alamat_domisili' => 'nullable|string',
        'bpjsket' => 'nullable|string',
        'pict_bpjsket' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'no_npwp' => 'nullable|string',
        'pict_npwp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'bpjskes' => 'nullable|string',
        'pict_bpjskes' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'status_kerja' => 'nullable|string',
        'pict_jobapp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'pict_pkwt' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        'gada_id1' => 'nullable|string',
        'gada_id2' => 'nullable|string',
        'gada_id3' => 'nullable|string',
        'gada_id1_other_text' => 'nullable|string',
        'gada_id2_other_text' => 'nullable|string',
        'gada_id3_other_text' => 'nullable|string',
        'lokasikerja' => 'nullable|string',
        'uk_sepatu' => 'nullable|string',
        'uk_seragam' => 'nullable|string',
    ]);

   // Logika pencarian data duplikat dengan pengecualian ID karyawan saat ini
   $existingEmployee = Employee::query()
    ->get() // Ambil semua data
    ->first(function ($item) use ($validatedData, $employee) {
        try {
            // Dekripsi nik_ktp
            $decryptedNikKtp = !empty($item->nik_ktp) ? Crypt::decryptString($item->nik_ktp) : null;
        } catch (\Exception $e) {
            $decryptedNikKtp = null;
        }

        // Abaikan karyawan yang sedang diperbarui
        if ($item->id === $employee->id) {
            return false;
        }

        // Periksa kecocokan nik_ktp
        return ($decryptedNikKtp === $validatedData['nik_ktp']);
    });

    if ($existingEmployee) {
        $isBlacklisted = DB::table('blacklists')
            ->where('employee_id', $existingEmployee->id)
            ->exists();

        if ($isBlacklisted) {
            return redirect()->back()->withErrors(['nik_ktp' => 'Data karyawan ini ditemukan dalam daftar blacklist.']);
        }

        return redirect()->back()->withErrors(['error' => 'NIK KTP ini telah terdaftar sebelumnya.']);
    }
    // Enkripsi data sensitif
    $encryptedFields = ['nik', 'nik_ktp', 'no_regkta', 'nama_ibu','nama_pasangan','nama_anak1','nama_anak2','nama_anak3', 'alamat_ktp', 'alamat_domisili', 'bpjsket', 'telp', 'no_npwp', 'bpjskes'];
    foreach ($encryptedFields as $field) {
        if (!empty($validatedData[$field])) {
            $validatedData[$field] = Crypt::encryptString($validatedData[$field]);
        }
    }

    // Penanganan file
    $fileFields = ['pict_diri','pict_sertifikat','pict_sertifikat1','pict_sertifikat2','pict_sertifikat3', 'pict_ktp', 'pict_kk', 'pict_kta', 'pict_npwp', 'pict_bpjsket', 'pict_bpjskes', 'pict_ijasah','pict_jobapp','pict_pkwt'];
    foreach ($fileFields as $fileField) {
        if ($request->hasFile($fileField)) {
             // Tentukan path penyimpanan file
                $directory = public_path('assets/berkas');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file($fileField)->getClientOriginalName();
                $filePath = 'assets/berkas/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file($fileField)->move($directory, $filePath);

                // Simpan path file ke array data
                $validatedData[$fileField] = $filePath;
        }
    }

  // Pastikan Gada ada atau buat jika belum ada
$gadaIds = ['gada_id1', 'gada_id2', 'gada_id3'];
$validGadaCount = 0;

foreach ($gadaIds as $gadaId) {
    if (!empty($validatedData[$gadaId . '_other_text'])) {
        // Cek dan buat jika belum ada untuk opsi "lainnya"
        $validatedData[$gadaId] = Gada::firstOrCreate([
            'name' => $validatedData[$gadaId . '_other_text']
        ])->id;
    }

    if (!empty($validatedData[$gadaId])) {
        $validGadaCount++;
    }
}

// Periksa jumlah valid Gada sebelum update atau insert
if ($validGadaCount >= 3) {
    // Update data karyawan
    $employee->update($validatedData);

    // Update GadaDetail hanya jika gada_id ada
    $gadaDetails = $employee->gadaDetail()->orderBy('id', 'asc')->get();
    foreach ($gadaIds as $index => $gadaId) {
        if (isset($validatedData[$gadaId])) {
            // Periksa jika nilai gada_id kosong atau null
            if ($validatedData[$gadaId] === null || $validatedData[$gadaId] === "") {
                // Hapus GadaDetail jika gada_id diubah menjadi kosong atau null
                if (isset($gadaDetails[$index])) {
                    GadaDetail::where('employee_id', $employee->id)
                        ->where('gada_id', $gadaDetails[$index]->gada_id)
                        ->delete();
                }
            } elseif (!empty($validatedData[$gadaId])) {
                // Update GadaDetail jika sudah ada
                if (isset($gadaDetails[$index])) {
                    // Hanya update jika gada_id berbeda
                    if ($gadaDetails[$index]->gada_id != $validatedData[$gadaId]) {
                        $gadaDetails[$index]->update(['gada_id' => $validatedData[$gadaId]]);
                    }
                } else {
                    // Jika GadaDetail belum ada, insert baru
                    GadaDetail::create([
                        'employee_id' => $employee->id,
                        'gada_id' => $validatedData[$gadaId],
                    ]);
                }
            }
        }
    }
} else {
   // Update data karyawan
    $employee->update($validatedData);

    // Update GadaDetail hanya jika gada_id ada
    $gadaDetails = $employee->gadaDetail()->orderBy('id', 'asc')->get();
    foreach ($gadaIds as $index => $gadaId) {
        if (isset($validatedData[$gadaId])) {
            // Periksa jika nilai gada_id kosong atau null
            if (!empty($validatedData[$gadaId])) {
                $existingGadaDetail = GadaDetail::where('employee_id', $employee->id)
                    ->where('gada_id', $validatedData[$gadaId])
                    ->first();

                if ($existingGadaDetail) {
                    // Update jika sudah ada
                    if ($existingGadaDetail->gada_id != $validatedData[$gadaId]) {
                        $existingGadaDetail->update(['gada_id' => $validatedData[$gadaId]]);
                    }
                } else {
                    // Insert baru jika belum ada
                    GadaDetail::create([
                        'employee_id' => $employee->id,
                        'gada_id' => $validatedData[$gadaId],
                    ]);
                }
            }
        }else{
            // Hanya melakukan penghapusan jika data tidak null dan tidak kosong
        if (isset($gadaDetails[$index]) && !empty($gadaDetails[$index]->gada_id)) {
            GadaDetail::where('employee_id', $employee->id)
                        ->where('gada_id', $gadaDetails[$index]->gada_id)
                        ->delete();
        }
        }
    }
}
 try {
if ($employee->name !== $validatedData['name']) {
    $employee->forceFill(['name' => $validatedData['name']])->save();
}
$employee->update(['name' => $validatedData['name']]);
} catch (\Exception $e) {
        // Log error
        \Log::error('Terjadi kesalahan saat memperbarui data karyawan:', [
            'id' => $employee->id,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
}
    return redirect()->route('admin.employee.index')->with('success', 'Karyawan berhasil diperbarui.');
 }



 public function deleteCertification(Request $request, $employeeId, $gadaDetailId)
{
    try {
        // Find the employee by ID
        $employee = Employee::findOrFail($employeeId);

        // Find the GadaDetail record by its ID
        $gadaDetail = GadaDetail::where('employee_id', $employee->id)
            ->where('id', $gadaDetailId)
            ->firstOrFail();

        // Delete the GadaDetail (certification)
        $gadaDetail->delete();

        // Return a success response
        return redirect()->back()->with('success', 'Sertifikasi berhasil dihapus.');
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        // Handle the case where the employee or GadaDetail is not found
        return redirect()->back()->with('error', 'Sertifikasi atau karyawan tidak ditemukan.');
    } catch (\Exception $e) {
        // Handle any general errors
        return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus sertifikasi.');
    }
}


public function export()
{
    try {
        $employees = Employee::with(['departemen', 'jabatan', 'gadaDetails.gada', 'partner'])->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $headings = [
            'NO', 'Name', 'NIK', 'NIK KTP', 'No KTA', 'Telepon', 'Email',
            'Alamat KTP', 'Alamat Domisili', 'Status', 'Pendidikan',
            'TMT', 'Departemen', 'Jabatan', 'Sertifikasi', 'Lokasi Kerja', 'TTL',
            'Nama Ibu', 'BPJS Ketenagakerjaan', 'BPJS Kesehatan',
            'No NPWP', 'Masa Berlaku PKWT', 'Keterangan'
        ];

        $column = 'A';
        foreach ($headings as $heading) {
            $sheet->setCellValue($column . '1', $heading);
            $column++;
        }

        $row = 2;
        $no = 1;
        foreach ($employees as $employee) {
            $sheet->setCellValue('A' . $row, $no++); // Nomor urut
            $sheet->setCellValue('B' . $row, $employee->name);

            // Format NIK dan NIK KTP sebagai teks
            $sheet->setCellValueExplicit('C' . $row, $employee->nik ? Crypt::decryptString($employee->nik) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('D' . $row, $employee->nik_ktp ? Crypt::decryptString($employee->nik_ktp) : '-', DataType::TYPE_STRING);

            $sheet->setCellValueExplicit('E' . $row, $employee->no_regkta ? Crypt::decryptString($employee->no_regkta) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('F' . $row, $employee->telp ? Crypt::decryptString($employee->telp) : '-', DataType::TYPE_STRING);

            $sheet->setCellValue('G' . $row, $employee->email);
            $sheet->setCellValueExplicit('H' . $row, $employee->alamat_ktp ? Crypt::decryptString($employee->alamat_ktp) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('I' . $row, $employee->alamat_domisili ? Crypt::decryptString($employee->alamat_domisili) : '-', DataType::TYPE_STRING);
            $sheet->setCellValue('J' . $row, $employee->status ?? '-');
            $sheet->setCellValue('K' . $row, $employee->pendidikan ?? '-');
            $sheet->setCellValue('L' . $row, $employee->tmt ?? '-');
            $sheet->setCellValue('M' . $row, optional($employee->departemen)->name ?? '-');
            $sheet->setCellValue('N' . $row, optional($employee->jabatan)->name ?? '-');

            $gadadetails = $employee->gadaDetails->pluck('gada.name')->take(3)->implode(', ');
            $sheet->setCellValue('O' . $row, $gadadetails ?: '-');

            $sheet->setCellValueExplicit('P' . $row, $employee->lokasikerja ?? '-', DataType::TYPE_STRING);
            $sheet->setCellValue('Q' . $row, $employee->ttl ?? '-');
            $sheet->setCellValueExplicit('R' . $row, $employee->nama_ibu ? Crypt::decryptString($employee->nama_ibu) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('S' . $row, $employee->bpjsket ? Crypt::decryptString($employee->bpjsket) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('T' . $row, $employee->bpjskes ? Crypt::decryptString($employee->bpjskes) : '-', DataType::TYPE_STRING);
            $sheet->setCellValueExplicit('U' . $row, $employee->no_npwp ? Crypt::decryptString($employee->no_npwp) : '-', DataType::TYPE_STRING);
            $sheet->setCellValue('V' . $row, $employee->berlaku ?? '-');
            $sheet->setCellValueExplicit('W' . $row, $employee->keterangan ?? '-', DataType::TYPE_STRING);

            $row++;
        }

        foreach (range('A', 'W') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'employees.xlsx';

        return response()->stream(function () use ($writer) {
            $writer->save('php://output');
        }, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment;filename="' . $fileName . '"',
            'Cache-Control' => 'max-age=0',
        ]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'Export failed: ' . $e->getMessage()], 500);
    }
}




    public function import(Request $request)
{
    try {
        // Validasi file yang diunggah
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        // Header yang diharapkan
        $headings = [
            'NO', 'Name', 'NIK', 'NIK KTP', 'No KTA', 'Telepon', 'Email',
            'Alamat KTP', 'Alamat Domisili', 'Status', 'Pendidikan',
            'TMT', 'Departemen', 'Jabatan', 'Sertifikasi', 'Lokasi Kerja', 'TTL',
            'Nama Ibu', 'BPJS Ketenagakerjaan', 'BPJS Kesehatan',
            'No NPWP', 'Masa Berlaku PKWT', 'Keterangan'
        ];

        // Load file Excel
        $file = $request->file('file')->getPathname();
        $spreadsheet = IOFactory::load($file);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true);

        // Validasi header
        $fileHeader = array_map('trim', $rows[1]);
        $headerMap = array_flip($fileHeader);
        foreach ($headings as $heading) {
            if (!isset($headerMap[$heading])) {
                return redirect()->route('admin.employee.index')
                    ->with('error', "Header '{$heading}' tidak ditemukan di file Excel.");
            }
        }

        // Proses data mulai dari baris kedua
        foreach (array_slice($rows, 1) as $index => $row) {
            // Validasi data wajib
            if (empty($row[$headerMap['NIK']]) || empty($row[$headerMap['Email']])) {
                continue; // Lewati jika data penting kosong
            }

            // Cek atau buat data terkait (Departemen, Jabatan, Partner)
            $departemen = Departemen::firstOrCreate(['name' => $row[$headerMap['Departemen']] ?? '']);
            $jabatan = Jabatan::firstOrCreate(['name' => $row[$headerMap['Jabatan']] ?? '']);
            $work = Work::firstOrCreate(['name' => $row[$headerMap['Lokasi Kerja']] ?? '']);
            $gada = Gada::firstOrCreate(['name' => $row[$headerMap['Sertifikasi']] ?? '']);

            // Cek apakah karyawan sudah ada berdasarkan NIK atau Email
            $existingEmployee = Employee::where('nik', Crypt::encryptString($row[$headerMap['NIK']] ?? ''))
                ->orWhere('email', $row[$headerMap['Email']] ?? '')
                ->first();

            if (!$existingEmployee) {
                // Buat karyawan baru
                $employee = Employee::create([
                    'name'               => $row[$headerMap['Name']] ?? null,
                    'nik'                => Crypt::encryptString($row[$headerMap['NIK']] ?? ''),
                    'nik_ktp'            => Crypt::encryptString($row[$headerMap['NIK KTP']] ?? ''),
                    'no_regkta'          => Crypt::encryptString($row[$headerMap['No KTA']] ?? ''),
                    'telp'               => Crypt::encryptString($row[$headerMap['Telepon']] ?? ''),
                    'email'              => $row[$headerMap['Email']] ?? null,
                    'alamat_ktp'         => Crypt::encryptString($row[$headerMap['Alamat KTP']] ?? ''),
                    'alamat_domisili'    => Crypt::encryptString($row[$headerMap['Alamat Domisili']] ?? ''),
                    'status'             => $row[$headerMap['Status']] ?? null,
                    'pendidikan'         => $row[$headerMap['Pendidikan']] ?? null,
                    'tmt'                => $this->transformDate($row[$headerMap['TMT']] ?? null),
                    'departemen_id'      => $departemen->id,
                    'jabatan_id'         => $jabatan->id,
                    'lokasikerja'         => $work->name,
                    'ttl'                => $this->transformDate($row[$headerMap['TTL']] ?? null),
                    'nama_ibu'           => Crypt::encryptString($row[$headerMap['Nama Ibu']] ?? ''),
                    'bpjsket'            => Crypt::encryptString($row[$headerMap['BPJS Ketenagakerjaan']] ?? ''),
                    'bpjskes'            => Crypt::encryptString($row[$headerMap['BPJS Kesehatan']] ?? ''),
                    'no_npwp'            => Crypt::encryptString($row[$headerMap['No NPWP']] ?? ''),
                    'berlaku'            => $row[$headerMap['Masa Berlaku PKWT']] ?? null,
                    'keterangan'         => $row[$headerMap['Keterangan']] ?? null,
                ]);
            } else {
                $employee = $existingEmployee;
            }

            // Cek dan tambahkan gada detail
            if ($gada && !$employee->gadaDetails->pluck('gada_id')->contains($gada->id)) {
                GadaDetail::create([
                    'employee_id' => $employee->id,
                    'gada_id'     => $gada->id,
                ]);
            }
        }

        return redirect()->route('admin.employee.index')
            ->with('success', 'Data karyawan berhasil diimpor.');
    } catch (\Exception $e) {
        return redirect()->route('admin.employee.index')
            ->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
    }
}



    private function transformDate($date)
    {
        if ($date instanceof \Carbon\Carbon) {
            return $date->format('Y-m-d');
        }

        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
        } catch (\Exception $e) {
            try {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d');
            } catch (\Exception $e) {
                return null; // Return null if date format is not recognized
            }
        }
    }

public function exportFotodiri($id)
{
    $employee = Employee::findOrFail($id);

    // Get the sertifikat file name from the database
    $ktpFile = $employee->pict_fotodiri;

    // Path to the sertifikat photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto diri tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);
    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_diri_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}

public function exportCertificate($id)
{
    $employee = Employee::findOrFail($id);

    // Get the sertifikat file name from the database
    $ktpFile = $employee->pict_sertifikat;

    // Path to the sertifikat photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto Sertifikat tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);
    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_sertifikat_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoKTA($id)
{
    $employee = Employee::findOrFail($id);

    // Get the sertifikat file name from the database
    $ktpFile = $employee->pict_kta;

    // Path to the sertifikat photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto KTA tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);
    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_KTA_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoKk($id)
{
    $employee = Employee::findOrFail($id);

    // Get the sertifikat file name from the database
    $ktpFile = $employee->pict_kk;

    // Path to the sertifikat photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto KK tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);
    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_KK_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoIjasah($id)
{
    $employee = Employee::findOrFail($id);

    // Get the sertifikat file name from the database
    $ktpFile = $employee->pict_ijasah;

    // Path to the sertifikat photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto Ijasah tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);
    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_ijasah_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportKTPPhoto($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_ktp;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto KTP tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_ktp_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoBpjsket($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_bpjsket;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto BPJSKET tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_bpjsket_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoBpjskes($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_bpjskes;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto BPJSKES tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_bpjskes_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportFotoNpwp($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_npwp;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto NPWP tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_NPWP_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}

public function exportFotoPkwt($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_pkwt;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto NPWP tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_PKWT_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}
public function exportLamaran($id)
{
    // Retrieve the employee record by ID
    $employee = Employee::findOrFail($id);

    // Get the KTP file name from the database
    $ktpFile = $employee->pict_jobapp;

    // Path to the KTP photo folder in public/assets/berkas
    $pathToKTPFile = public_path($ktpFile);

    // Check if the file exists
    if (!$ktpFile || !file_exists($pathToKTPFile)) {
        return redirect()->back()->with('error', 'File foto NPWP tidak ditemukan.');
    }

    // Get file extension to preserve it (for example, .png, .jpg, etc.)
    $fileExtension = pathinfo($ktpFile, PATHINFO_EXTENSION);

    // Clean the employee name and create a new filename
    $cleanName = preg_replace('/[^A-Za-z0-9_-]/', '', str_replace(' ', '_', $employee->name));
    $downloadFileName = "foto_Lamaran_{$cleanName}.{$fileExtension}";

    // Download the file with the new name
    return response()->download($pathToKTPFile, $downloadFileName);
}

    public function aktif($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            Log::info("Attempting to update status_kerja to 'aktif' for employee ID: $id");

            // Pastikan status_kerja hanya diubah menjadi 'aktif'
            if ($employee->status_kerja !== 'aktif') {
                $employee->update(['status_kerja' => 'aktif']);
                Log::info("Status kerja successfully updated to 'aktif' for employee ID: $id");
            }

            return redirect()->route('admin.employee.index')->with('success', 'Status kerja karyawan berhasil diperbarui menjadi aktif.');
        } catch (\Exception $e) {
            Log::error("Failed to update status_kerja to 'aktif' for employee ID: $id", [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.employee.index')->with('error', 'Gagal memperbarui status kerja karyawan.');
        }
    }

    public function nonaktif($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            Log::info("Attempting to update status_kerja to 'nonaktif' for employee ID: $id");

            // Pastikan status_kerja hanya diubah menjadi 'nonaktif'
            if ($employee->status_kerja !== 'nonaktif') {
                $employee->update(['status_kerja' => 'nonaktif']);
                Log::info("Status kerja successfully updated to 'nonaktif' for employee ID: $id");
            }

            return redirect()->route('admin.employee.index')->with('success', 'Status kerja karyawan berhasil diperbarui menjadi nonaktif.');
        } catch (\Exception $e) {
            Log::error("Failed to update status_kerja to 'nonaktif' for employee ID: $id", [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.employee.index')->with('error', 'Gagal memperbarui status kerja karyawan.');
        }
    }

    public function blacklist($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            Log::info("Attempting to update status_kerja to 'blacklist' for employee ID: $id");

            // Pastikan status_kerja hanya diubah menjadi 'blacklist'
            if ($employee->status_kerja !== 'blacklist') {
                $employee->update(['status_kerja' => 'blacklist']);
                Log::info("Status kerja successfully updated to 'blacklist' for employee ID: $id");

                Blacklist::create([
                    'employee_id' => $employee->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                Log::info("Employee ID: $id added to blacklist table");
            }

            return redirect()->route('admin.employee.index')->with('success', 'Karyawan berhasil dimasukkan ke daftar blacklist.');
        } catch (\Exception $e) {
            Log::error("Failed to update status_kerja to 'blacklist' or add to blacklist table for employee ID: $id", [
                'error' => $e->getMessage(),
            ]);
            return redirect()->route('admin.employee.index')->with('error', 'Gagal memproses blacklist untuk karyawan.');
        }
    }

public function deleteDocument($employeeId, $documentKey)
{
    // Find the employee by ID
    $employee = Employee::findOrFail($employeeId);

    // Update the document field to null
    $employee->{'pict_' . $documentKey} = null;

    // Save the changes to the employee
    $employee->save();

    // Redirect back with success message
    return redirect()->back()->with('success', ucfirst($documentKey) . ' has been deleted.');
}




}
