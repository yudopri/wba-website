<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationUser extends Model
{protected $table = 'notifikasis';
    protected $fillable = [
        'user_id', 'tipe', 'pesan', 'sudah_dibaca','judul','dibaca'
    ];



    public function user()
{
    return $this->belongsTo(User::class);
}
}
