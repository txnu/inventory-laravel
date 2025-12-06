<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseOrderFactory> */
    use HasFactory;

    protected $table = 'purchase_orders';
    protected $primaryKey = 'po_id';

    protected $fillable = [
        'po_code',
        'supplier_id',
        'order_date',
        'delivery_date',
        'status',
        'notes',
        'total_amount'
    ];


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }
}
