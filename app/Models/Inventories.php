<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Employee;
use App\Models\InventoryItem;

class Inventories extends Model
{
    use HasFactory;

    protected $table = 'inventories';

    protected $fillable = [
        'id_user',
        'id_karyawan',
        'id_inventori',
        'quantity',
        'foto_bukti',
        'keterangan',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'id_karyawan');
    }

    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class, 'id_inventori');
    }
}
