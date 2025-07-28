<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KasLogistik extends Model
{
    protected $table = 'kas_logistik'; // <- ini penting!
    
    protected $fillable = [
        'keterangan', 'debit', 'kredit', 'saldo_setelah'
    ];
}