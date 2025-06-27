<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak mengikuti konvensi plural dari nama model
    protected $table = 'work_locations';
    public $timestamps = false;
    // Tentukan kolom yang dapat diisi (mass assignable)
    protected $fillable = [
        'name',
        'berlaku',
    ];

}

