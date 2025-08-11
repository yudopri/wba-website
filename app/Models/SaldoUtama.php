<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaldoUtama extends Model
{
    //
    use HasFactory;
protected $table = 'main_balances';
    protected $fillable = ['id_user', 'debit', 'kredit', 'keterangan'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
