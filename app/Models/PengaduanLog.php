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
        'approved_at',
        'keterangan',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
//     public function logs()
// {
//     return $this->hasMany(PengaduanLog::class);
// } iki ga guna

}
