<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    // Show list of all services
    public function index()
    {
        // Get all services from the database
        $services = Service::all();

        // Return the view with the services data
        return view('admin.service.index', compact('services'));
    }

    public function showUser()
    {
        // Get all services from the database
        $services = Service::all();

        // Return the view with the services data
        return view('layanan', compact('services'));
    }
    // Show form to create a new service
    public function create()
    {
        return view('admin.service.create');
    }

    // Store a new service
    public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'name_service' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Pastikan folder tujuan ada
    $directory = public_path('assets/services');
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true); // Buat folder dengan izin akses
    }

    // Simpan file ke folder
    $iconPath = 'assets/services/' . time() . '_' . $request->file('icon')->getClientOriginalName();
    $request->file('icon')->move($directory, $iconPath);

    // Simpan data ke database
    Service::create([
        'name_service' => $request->name_service,
        'description' => $request->description,
        'icon' => $iconPath, // Simpan path relatif
    ]);

    return redirect()->route('admin.service.index')->with('message', 'Service added successfully');
}

public function update(Request $request, Service $service)
{
    $request->validate([
        'name_service' => 'required|string|max:255',
        'description' => 'required|string',
        'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Pastikan folder tujuan ada
    $directory = public_path('assets/services');
    if (!File::exists($directory)) {
        File::makeDirectory($directory, 0755, true); // Buat folder dengan izin akses
    }

    if ($request->hasFile('icon')) {
        // Hapus file lama jika ada
        if ($service->icon && File::exists(public_path($service->icon))) {
            File::delete(public_path($service->icon));
        }

        // Simpan file baru
        $iconPath = 'assets/services/' . time() . '_' . $request->file('icon')->getClientOriginalName();
        $request->file('icon')->move($directory, $iconPath);

        $service->icon = $iconPath;
    }

    $service->update([
        'name_service' => $request->name_service,
        'description' => $request->description,
    ]);

    return redirect()->route('admin.service.index')->with('message', 'Service updated successfully');
}

    // Show form to edit an existing service
    public function edit($id)
    {
        // Fetch the service to be edited
        $service = Service::findOrFail($id);

        // Return the edit view with the service data
        return view('admin.service.edit', compact('service'));
    }




    // Update an existing service

    // Delete a service
    public function destroy($id)
{
    // Find the service by ID
    $service = Service::findOrFail($id);

    // Delete the service
    $service->delete();

    // Redirect back with a success message
    return redirect()->route('admin.service.index')->with('message', 'Service deleted successfully');
}
public function show($id)
    {
        // Find the service by ID
        $service = Service::findOrFail($id);

        // Return a view with the service data
        return view('admin.service.show', compact('service'));
    }

}
