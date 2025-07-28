<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasOperasional extends Model
{
    use HasFactory;
protected $table = 'kas_operasional'; // ⬅️ tambahkan ini
    protected $fillable = [
        'keterangan',
        'debit',
        'kredit',
        'saldo_setelah',
    ];
}
