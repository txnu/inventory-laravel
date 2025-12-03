<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    /** @use HasFactory<\Database\Factories\StockAdjustmentFactory> */
    use HasFactory;

    protected $table = 'stock_adjustments';
    protected $primaryKey = 'stock_a_id';

    protected $fillable = [
        'product_id',
        'product_stock_id',
        'system_qty',
        'physical_qty',
        'difference',
        'reason',
        'performed_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'product_stock_id', 'stock_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by', 'user_id');
    }
}
