<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

     // Relasi Departemen dengan Employee
     public function employees()
     {
         return $this->hasMany(Employee::class);
     }
}
