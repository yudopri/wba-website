<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class RealtimeDatabaseController extends Controller
{
    private $database;

    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    public function addData()
    {
        $reference = $this->database->getReference('users');
        $reference->push([
           'name' => 'admin',
            'email' => 'admin@admin.com',
        ]);

        return response()->json(['status' => 'Data added']);
    }
}
