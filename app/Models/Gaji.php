<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\GajiLog;

class Gaji extends Model
{
    use HasFactory;

    protected $fillable = ['nama_pt', 'nominal', 'bulan', 'status'];

    // Relasi ke logs
    public function logs()
    {
        return $this->hasMany(GajiLog::class, 'penggajian_id');
    }
}
