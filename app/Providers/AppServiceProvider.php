<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // View Composer untuk mengubah title dan logo
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                
                // Set title dan logo berdasarkan role pengguna
                if ($user->role == 'Admin') {
                    config(['adminlte.title' => 'Admin WBA']);
                    config(['adminlte.logo' => '<b>Admin</b> WBA']);
                } elseif ($user->role == 'Karyawan') {
                    config(['adminlte.title' => 'Kary WBA']);
                    config(['adminlte.logo' => '<b>Karyawan</b> WBA']);
                } else {
                    config(['adminlte.title' => 'Manager WBA']);
                    config(['adminlte.logo' => '<b>Manager</b> WBA']);
                }
            }
        });

        
    }
}
