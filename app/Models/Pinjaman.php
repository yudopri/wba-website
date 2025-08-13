<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'loan_cash'; // Nama tabel
    protected $fillable = [
        'debit',
        'kredit',
        'saldo',
        'keterangan',
        'id_user'
    ];
}
