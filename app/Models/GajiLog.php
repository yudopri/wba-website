<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiLog extends Model
{
    protected $table = 'gajis_logs'; // Sesuaikan dengan nama tabel sebenarnya

    protected $fillable = [
        'gaji_id',
        'keterangan',
        'nominal',
        'person',
        'created_at',
        'updated_at',
    ];

    public function penggajian()
    {
        return $this->belongsTo(Gaji::class, 'penggajian_id');
    }
}
