<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;

class FirebaseServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Register Firebase service instance untuk digunakan di seluruh aplikasi
        $this->app->singleton('firebase', function () {
            return (new Factory)->withServiceAccount(env('FIREBASE_CREDENTIALS'))->create();
        });
    }

    public function boot()
    {
        //
    }
}
