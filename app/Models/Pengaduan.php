<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul', 'deskripsi', 'status', 'pelapor', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function logs()
{
    return $this->hasMany(\App\Models\PengaduanLog::class, 'pengaduan_id');
}

}
