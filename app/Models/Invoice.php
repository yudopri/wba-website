<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
protected $table = 'invoices';
    protected $fillable = ['lokasi_kerja', 'jumlah_personil', 'nominal', 'bulan', 'date_send', 'date_pay', 'status', 'id_user'];
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}
}
