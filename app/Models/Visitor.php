<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = ['visitor_id'];

    // Optionally, you can define the table name if it's not the plural of the model name
    // protected $table = 'visitors';
}
