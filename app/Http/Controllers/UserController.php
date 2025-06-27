<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
   public function index(Request $request)
{
    // Mulai query dengan kondisi awal
    $query = User::query();

    // Filter untuk role 'Karyawan'
    if (auth()->user()->role === 'Karyawan') {
        $query->where('id', auth()->user()->id); // Hanya data user yang sedang login
    } else {
        // Prioritaskan akun yang sedang login
        $query->orderByRaw('id = ? DESC', [auth()->user()->id]);
    }

    // Filter berdasarkan pencarian
    if ($request->filled('search')) {
        $query->where(function ($subQuery) use ($request) {
            $subQuery->where('name', 'like', '%' . $request->search . '%')
                     ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    // Tambahkan pengurutan berdasarkan role
    $query->orderByRaw("FIELD(role, 'Manager', 'Admin', 'Karyawan') ASC");

    // Gunakan paginate untuk hasil akhir
    $users = $query->paginate(15);

    return view('admin.user.index', compact('users'));
}




    public function create()
    {
        return view('admin.user.create');
    }

    public function show($id)
    {
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Return the view with the user data
        return view('admin.user.show', compact('user'));
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle the profile picture upload if present
        $imagePath = null;

        // Simpan file jika ada
            if ($request->hasFile('profile_picture')) {
                // Tentukan path penyimpanan file
                $directory = public_path('assets/profiles');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
                $filePath = 'assets/profiles/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file('profile_picture')->move($directory, $filePath);

                // Simpan path file ke array data
                $imagePath = $filePath;
            }

        // Get the role from the request
        $role = $request->role;

        // Always set email_verified_at to the current date and time
        $emailVerifiedAt = now();

        // Create a new user with the validated data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Use bcrypt for password hashing
            'email_verified_at' => $emailVerifiedAt, // Set current timestamp
            'role' => $role,
            'profile_picture' => $imagePath,
            'verifikasi' => true, // Set verifikasi as true (user is verified)
        ]);

        // Redirect back to the user index with a success message
        return redirect()->route('admin.user.index')->with('success', 'User created successfully.');
    }





    public function edit($id)
    {
        // Find the user by ID or fail
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
{
    // Validate the incoming request data
    $request->validate([
        'name' => 'nullable|string|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'password' => 'nullable|string|min:8',
        'role' => 'required|string|max:255',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Initialize the profile picture path (keep the old one by default)
    $imagePath = null;

   // Simpan file jika ada
            if ($request->hasFile('profile_picture')) {
                // Tentukan path penyimpanan file
                $directory = public_path('assets/profiles');

                // Cek dan buat folder jika belum ada
                if (!File::exists($directory)) {
                    File::makeDirectory($directory, 0755, true); // Buat folder jika belum ada
                }

                // Generate nama file dan tentukan path
                $fileName = time() . '_' . $request->file('profile_picture')->getClientOriginalName();
                $filePath = 'assets/profiles/' . $fileName;

                // Pindahkan file ke folder yang ditentukan
                $request->file('profile_picture')->move($directory, $filePath);

                // Simpan path file ke array data
                $imagePath = $filePath;
            }
    // Check if the password is provided and hash it if necessary
    $hashedPassword = $request->password ? Hash::make($request->password) : $user->password;

    // Always set email_verified_at to the current date and time
    $emailVerifiedAt = now();

    // Update the user with the new data
    $updated = $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $hashedPassword,
        'role' => $request->role,
        'profile_picture' => $imagePath,
    ]);

    // Check if the update was successful
    if ($updated) {
        // Redirect with success message
        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    } else {
        // Log the failure and return an error message
        \Log::error('User update failed for user ID: ' . $user->id);
        return back()->withErrors(['error' => 'Failed to update the user.']);
    }
}

    public function destroy(User $user)
    {
        // Delete profile picture if it exists
        if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
            Storage::delete('public/' . $user->profile_picture);
        }

        // Delete the user
        $user->delete();

        // Redirect with success message
        return redirect()->route('admin.user.index')->with('success', 'User deleted successfully.');
    }
}
