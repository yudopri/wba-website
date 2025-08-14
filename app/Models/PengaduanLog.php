<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanLog extends Model
{
    use HasFactory;
protected $table = 'complaint_approvals';
    protected $fillable = [
        'id_complaint',
        'id_user',
        'status',
        'deskripsi',
        'approved_at',
        'keterangan',
    ];

   public function pengaduan()
{
    return $this->belongsTo(Pengaduan::class, 'id_complaint');
}

    public function logs()
{
    return $this->hasMany(PengaduanLog::class);
}
public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
public function deskripsi()
    {
        return $this->belongsTo(pengaduan::class, 'deskripsi');
    }

}
