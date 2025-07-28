<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasOperasional extends Model
{
    use HasFactory;
protected $table = 'operational_petty_cash'; // ⬅️ tambahkan ini
    protected $fillable = [
        'keterangan',
        'debit',
        'kredit',
        'saldo',
        'id_user',
    ];
    // benerno sesuai iki
}