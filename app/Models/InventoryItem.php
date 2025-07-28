<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;
protected $table = 'inventory_items';
    protected $fillable = ['id_user', 'nama_barang', 'stock', 'quantity', 'price','status', 'jenis_barang'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
