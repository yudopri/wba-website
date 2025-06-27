<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;

class FirestoreController extends Controller
{
    private $firestore;

    public function __construct()
    {
        $this->firestore = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->createFirestore()
            ->database();
    }

    public function addData()
    {
        $this->firestore->collection('users')->add([
            'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        return response()->json(['status' => 'Data added']);
    }
}
