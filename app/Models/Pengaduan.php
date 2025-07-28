<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;
protected $table = 'complaint_reports';
    protected $fillable = [
        'judul', 'deskripsi', 'status', 'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
   public function logs()
{
    return $this->hasMany(PengaduanLog::class, 'id_complaint');
}


}
