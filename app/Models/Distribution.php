<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Distribution extends Model
{
     use HasFactory;
protected $table = 'distributions';
    protected $fillable = ['id_user', 'id_karyawan', 'id_inventori', 'quantity', 'keterangan', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_karyawan');
    }
    // Relasi ke InventoryItem (Barang yang dipinjamkan)
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'id_inventori');
    }
}
