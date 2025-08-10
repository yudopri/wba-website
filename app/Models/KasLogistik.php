<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasLogistik extends Model
{
    protected $table = 'logistics_cash'; // <- ini penting!

    protected $fillable = [
        'keterangan', 'debit', 'kredit', 'saldo', 'id_user',
    ];
     // benerno sesuai iki
}
