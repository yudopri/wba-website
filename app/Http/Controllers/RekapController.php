<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class RekapController extends Controller
{
    public function index()
    {
        // Ambil semua karyawan
        $employees = Employee::all();

        // Kirim variabel $employees ke view
        return view('admin.distributions.rekapseragam', compact('employees'));
    }
}
