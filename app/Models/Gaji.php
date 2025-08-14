<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'salaries';

    protected $fillable = [
        'partner_id',
        'id_user',
        'nominal',
        'bulan',
        'status'
    ];

    public function logs()
    {
        return $this->hasMany(GajiLog::class, 'gaji_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class, 'partner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
