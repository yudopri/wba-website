<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;
<<<<<<< HEAD

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


=======
    protected $table = 'salaries';
    protected $fillable = ['partner_id', 'id_user', 'nominal', 'bulan'];

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function logs()
    {
        return $this->hasMany(GajiLog::class);
    }
>>>>>>> 0dc353bdb7868fa53612faccfcb2922d594ecb60
}

