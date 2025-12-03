<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Stock extends Model
{
    use HasFactory;

    protected $table = 'stocks';
    protected $primaryKey = 'stock_id';

    protected $fillable = [
        'product_id',
        'qty_on_hand',
        'qty_reserved',

    ];

    protected $appends = ['qty_available'];

    public function getQtyAvailableAttribute()
    {
        return $this->qty_on_hand - $this->qty_reserved;
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
