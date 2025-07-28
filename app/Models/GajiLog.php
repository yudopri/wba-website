<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiLog extends Model
{
    use HasFactory;

    protected $table = 'gajis_logs'; // karena bukan plural standar 'gaji_logs'

    protected $fillable = [
        'penggajian_id',
        'keterangan',
        'person',
        'deskripsi',
    ];

    public function gaji()
    {
        return $this->belongsTo(Gaji::class, 'penggajian_id');
    }
}
