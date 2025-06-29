<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasLokasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'keterangan',
        'debit',
        'kredit',
        'saldo_setelah',
        'lokasi',
    ];
}
