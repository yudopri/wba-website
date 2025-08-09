<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogisticsCash extends Model
{
    use HasFactory;

    protected $table = 'logistics_cash';

    protected $fillable = [
        'id_user',
        'keterangan',
        'debit',
        'kredit',
        'saldo',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
