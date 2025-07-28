<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenLokasi extends Model
{
    protected $table = 'dokumen_lokasi';
    protected $fillable = [
        'nama_lokasi',
        'nama_file',
        'file_path',
    ];
    // iki gausah, melu model work
}
