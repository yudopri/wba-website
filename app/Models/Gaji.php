<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GajiLog;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'salaries';
    protected $fillable = ['id_karyawan','id_user', 'nominal', 'bulan', 'status'];
  // benerno sesuai iki
}
