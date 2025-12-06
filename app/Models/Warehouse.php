<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    /** @use HasFactory<\Database\Factories\WarehouseFactory> */
    use HasFactory;

    protected $table = 'warehouses';
    protected $primaryKey = 'warehouse_id';

    protected $fillable = [
        'warehouse_code',
        'warehouse_name',
        'description',
        'country',
        'province',
        'city',
        'postal_code',
        'address',
        'contact_person',
        'contact_phone',
        'is_active'
    ];
}
