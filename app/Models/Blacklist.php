<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    //
    use HasFactory;

    protected $fillable = ['employee_id'];

    public function employees()
    {
        return $this->belongsTo(Employee::class);
    }

}
