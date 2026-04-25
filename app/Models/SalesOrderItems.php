<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrderItems extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'sales_order_id',
        'product_id',
        'quantity',
        'unit_price',
        'discount',
        'subtotal',
        'total_price',
        'created_at',
        'updated_at',
    ];

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
