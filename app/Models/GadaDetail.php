<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GadaDetail extends Model
{
    use HasFactory;

    protected $fillable = ['gada_id', 'employee_id'];
    public $timestamps = false;
     // Relasi Departemen dengan Gada
    public function gada()
{
    return $this->belongsTo(Gada::class);
}

     public function employees()
     {
         return $this->hasMany(Employee::class);
         return $this->belongsTo(Employee::class, 'employee_id', 'id');
     }
}
