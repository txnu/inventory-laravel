<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $table = 'stock_movements';
    protected $primaryKey = 'stock_m_id';

    protected $fillable = [
        'product_id',
        'product_stock_id',
        'movement_type',
        'reference_type',
        'reference_id',
        'qty',
        'before_qty',
        'after_qty',
        'created_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function stock()
    {
        return $this->belongsTo(Stock::class, 'product_stock_id', 'stock_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'user_id');
    }
}
