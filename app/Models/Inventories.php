<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventories extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'id_user', // Pengelola (admin) yang mengelola pinjaman
        'id_karyawan', // Karyawan yang meminjam barang
        'id_inventori', // Barang yang dipinjam dari inventory_items
        'quantity', // Jumlah barang yang dipinjam
        'keterangan', // Keterangan tambahan terkait barang pinjaman
        'status', // Status pinjaman (misalnya: belum dikembalikan, sudah dikembalikan)
    ];

    // Relasi ke User (Pengelola yang menyetujui pinjaman)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke Employee (Karyawan yang meminjam barang)
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
