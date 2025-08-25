<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class RekapController extends Controller
{
    public function index()
    {
        // Path folder rekap
        $folderPath = public_path('assets/rekapseragam');

        // Ambil semua file di folder tersebut
        $files = File::files($folderPath);

        // Ubah menjadi array nama file saja
        $fileNames = [];
        foreach ($files as $file) {
            $fileNames[] = $file->getFilename();
        }

        // Kirim ke view
        return view('admin.distributions.rekapseragam', compact('fileNames'));
    }
}
