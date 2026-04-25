<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id',
        'order_code',
        'customer_id',
        'order_date',
        'delivery_date',
        'status',
        'subtotal',
        'tax',
        'total',
        'payment_status',
        'shipping_status',
        'notes',
        'created_by',
        'created_at',
        'updated_at',

    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItems::class, 'sales_order_id');
    }
}
