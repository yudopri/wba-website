<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Add the Hash facade for hashing
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;



class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
{
    // Redirect to dashboard if already logged in
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }


    return view('auth.login');
}

    // Handle login request
    public function login(Request $request)
    {
        // Validate input data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        // Check if the user exists and authenticate
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            $user = Auth::user();

            // Check if the email is verified
            if (!$user->hasVerifiedEmail()) {
                // Log the user out if their email is not verified
                Auth::logout();

                return redirect()->route('login')->withErrors([
                    'email' => 'Your email address is not verified. Please check your inbox to verify your email.',
                ]);
            }

            // Redirect to the dashboard if email is verified
            return redirect()->route('admin.dashboard');
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials are incorrect.',
        ]);
    }

    // Show registration form
    public function showRegisterForm()
    {
        // Redirect to dashboard if already logged in
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.register');
    }

    // Handle registration request (No email verification at this stage)
    public function register(Request $request)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the new user (without triggering email verification)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Log the user in immediately after registration
        Auth::login($user);

        // Redirect the user to the dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Registration successful! Please verify your email.');
    }

    // Handle logout
    public function logout()
    {
        Auth::logout();

        // Redirect to login page after logout
        return redirect()->route('login');
    }

    // Menampilkan form forgot password
    public function showForgotPasswordForm()
    {
        $notifications = Auth::user() ? Auth::user()->notifications : [];
        return view('auth.passwords.email', compact('notifications'));
    }

    public function sendResetLink(Request $request)
{
    $request->validate(['email' => 'required|email']);

    // Check if the user exists
    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'This email address is not registered.']);
    }

// Generate and hash the password reset token
$token = Str::random(60); // Generate the reset token
$hashedToken = Hash::make($token); // Hash the token

// Store the token in the password_resets table
\DB::table('password_reset_tokens')->insert([
    'email' => $user->email,
    'token' => $hashedToken, // Simpan token yang sudah di-hash
    'created_at' => now(),
]);
    // Create the reset password URL
    $resetLink = URL::temporarySignedRoute(
        'password.reset', // The route name for resetting the password
        now()->addMinutes(60), // Link expiration time
        ['token' => $token, 'email' => $user->email]
    );

    // Redirect the user to the reset password link
    return redirect($resetLink);
}

    // Menampilkan form reset password
    public function showResetPasswordForm($token, $email)
    {
        return view('auth.passwords.reset', compact('token', 'email'));
    }


    // Meng-handle reset password
    public function resetPassword(Request $request)
{
    // Validasi input dari request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    // Temukan pengguna berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Cek apakah pengguna ada
    if (!$user) {
        return back()->withErrors(['email' => 'User not found.']);
    }

    // Update password jika pengguna ditemukan
    $user->update([
        'password' => Hash::make($request->password), // Hash password sebelum disimpan
    ]);

    // Menghasilkan token baru jika diperlukan
    $user->update([
        'remember_token' => Str::random(60), // Menghasilkan token baru
    ]);

    // Redirect ke halaman login setelah password berhasil direset
    return redirect()->route('login')->with('status', __('Your password has been reset successfully.'));
}


}
