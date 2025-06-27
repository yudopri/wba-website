<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Employee;

class PartnerController extends Controller
{
    public function index()
    {
       

        // Inisialisasi query untuk model Employee
        $query = Employee::query();

        // Periksa apakah request memiliki parameter 'partner_id'
        if (request()->has('partner_id')) {
            $partnerId = request()->input('partner_id');

            // Tambahkan kondisi untuk menghitung jumlah karyawan berdasarkan partner ID
            $employeeCount = $query->where('partner_id', $partnerId)->count();
        } else {
            // Jika tidak ada partner_id, hitung semua karyawan
            $employeeCount = $query->count();
        }
        
        $partners = Partner::paginate(10);
        // Kembalikan view dengan data partners dan jumlah karyawan
        return view('admin.partner.index', compact('partners', 'employeeCount'));
    }
  public function showEmployees($id)
{
    $partner = Partner::findOrFail($id);
    $employees = $partner->employees; // Assuming the relationship is 'employees'
    return view('admin.partner.showemployee', compact('employees'));
}


    public function showUser()
    {
        // Get all services from the database
        $partners = Partner::all();

        // Return the view with the services data
        return view('client', compact('partners'));
    }
    public function showUserHome()
    {
        $slides = ['slide_1.jpeg', 'slide_2.jpeg', 'slide_3.jpeg'];
        $partners = Partner::limit(10)->get(); // Retrieve only 6 partners
        return view('home', compact('partners','slides'));
    }

    // Show form to create a new service
    public function create()
    {
        return view('admin.partner.create');
    }

    // Store a new service
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name_partner' => 'required|string|max:255',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the icon
        ]);

        // Store the icon in the internal storage and get the file path
        // $iconPath = $request->file('icon')->store('partner', 'public'); // Store in internal storage
        $imagePath = null;

        // Simpan file jika ada
            if ($request->hasFile('icon')) {
                // Tentukan path penyimpanan file
                $directory = public_path('assets/partners');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file('icon')->getClientOriginalName();
                $filePath = 'assets/partners/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file('icon')->move($directory, $filePath);

                // Simpan path file ke array data
                $iconPath = $filePath;
            }


        // Create a new service entry in the database
        Partner::create([
            'name_partner' => $request->name_partner,
            'icon' => $iconPath,  // Store the path of the icon
        ]);

        // Redirect to the index route
        return redirect()->route('admin.partner.index');
    }

    public function update(Request $request, Partner $partner)
    {
        // Validate the request data
        $request->validate([
            'name_partner' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // If a new icon is uploaded, store it and get the path
        $imagePath = null;

        // Simpan file jika ada
            if ($request->hasFile('icon')) {
                // Tentukan path penyimpanan file
                $directory = public_path('assets/partners');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file('icon')->getClientOriginalName();
                $filePath = 'assets/partners/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file('icon')->move($directory, $filePath);

                // Simpan path file ke array data
                $partner->icon = $filePath;
            }

        // Update the service in the database
        $partner->update([
            'name_partner' => $request->name_partner,
        ]);

        // Redirect to the index route
        return redirect()->route('admin.partner.index');
    }

    // Show form to edit an existing service
    public function edit($id)
    {
        // Fetch the service to be edited
        $partner = Partner::findOrFail($id);

        // Return the edit view with the service data
        return view('admin.partner.edit', compact('partner'));
    }




    // Update an existing service

    // Delete a service
    public function destroy($id)
{
    // Find the service by ID
    $partner = Partner::findOrFail($id);

    // Delete the service
    $partner->delete();

    // Redirect back with a success message
    return redirect()->route('admin.partner.index')->with('message', 'Partner deleted successfully');
}
public function show($id)
    {
        // Find the service by ID
        $partner = Partner::findOrFail($id);

        // Return a view with the service data
        return view('admin.partner.show', compact('partner'));
    }
}
