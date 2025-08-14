<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pajak extends Model
{
    //
     use HasFactory;
protected $table = 'tax_cash'; // ⬅️ tambahkan ini
    protected $fillable = [
        'keterangan',
        'debit',
        'kredit',
        'saldo',
        'id_user',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
