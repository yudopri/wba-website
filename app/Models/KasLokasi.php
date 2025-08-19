<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasLokasi extends Model
{
    use HasFactory;
protected $table = 'location_petty_cash';
    protected $fillable = [
        'keterangan',
        'debit',
        'kredit',
        'saldo',
        'created_at',
        'lokasi_kerja','id_user',
    ];
     // benerno sesuai iki
     public function work()
{
    return $this->belongsTo(Work::class, 'lokasi_kerja', 'name');
}

}
