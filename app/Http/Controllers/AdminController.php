<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Handle the admin dashboard view
    public function dashboard()
    {
        return view('admin.dashboard'); // Assuming the view is located in resources/views/admin/dashboard.blade.php
    }

    // Handle the data jasa view
    public function datajasa()
    {
        return view('admin.datajasa.index'); // Assuming the view is located in resources/views/admin/datajasa.blade.php
    }

    //data patner view
    public function datapartner()
    {
        return view('admin.datapartner'); // Assuming the view is located in resources/views/admin/datajasa.blade.php
    }
}

