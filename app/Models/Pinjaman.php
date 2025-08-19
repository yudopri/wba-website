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
        'created_at',
        'id_user'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
