<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate untuk akses Master Karyawan
        Gate::define('view-master-karyawan', function ($user) {
            // Karyawan dan head bisa melihat Master Karyawan
            return in_array($user->role, ['karyawan', 'head']);
        });

        // Gate untuk akses Data Karyawan
        Gate::define('view-karyawan', function ($user) {
            // Karyawan dan head bisa mengakses Data Karyawan
            return in_array($user->role, ['karyawan', 'head']);
        });

        // Gate untuk akses Data Departemen (Hanya head yang bisa mengakses)
        Gate::define('manage-departemen', function ($user) {
            return $user->role === 'head';
        });

        // Gate untuk akses Data Jabatan (Hanya head yang bisa mengakses)
        Gate::define('manage-jabatan', function ($user) {
            return $user->role === 'head';
        });

        // Gate untuk akses Data Account (Hanya head yang bisa mengakses)
        Gate::define('is-head', function ($user) {
            return $user->role === 'head';
        });
    }
}
