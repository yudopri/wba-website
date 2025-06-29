<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'keterangan',
        'deskripsi',
        'person',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
    public function logs()
{
    return $this->hasMany(PengaduanLog::class);
}

}
