<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GajiLog;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'salaries'; // Nama tabel diubah

    // Kolom yang bisa diisi
    protected $fillable = ['id_karyawan', 'id_user', 'nominal', 'bulan', 'status'];

    // Relasi ke logs
    public function logs()
    {
        return $this->hasMany(GajiLog::class, 'penggajian_id');
    }

public function karyawan()
{
    return $this->belongsTo(Employee::class, 'id_karyawan');
}

public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}


}
