<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItems extends Model
{
    use HasFactory;

    protected $table = 'purchase_order_items';
    protected $primaryKey = 'po_item_id';

    protected $fillable = [
        'po_id',
        'product_id',
        'qty_ordered',
        'qty_received',
        'price',
        'total'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
