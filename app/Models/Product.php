<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $fillable = [
        'sku',
        'product_name',
        'description',
        'category_id',
        'unit_id',
        'purchase_price',
        'selling_price',
        'barcode',
        'image_url',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'category_id');
    }

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_id', 'product_id');
    }

    public function getStockQuantityAttribute()
    {
        if (!$this->stock) {
            return 0;
        }

        return $this->stock->qty_on_hand - $this->stock->qty_reserved;
    }
}
