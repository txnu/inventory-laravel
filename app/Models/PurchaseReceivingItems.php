<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReceivingItems extends Model
{
    use HasFactory;

    protected $table = 'purchase_receiving_items';
    protected $primaryKey = 'pr_item_id';

    protected $fillable = [
        'receiving_id',
        'product_id',
        'qty_received',
        'note',
    ];

    public function purchase_receiving()
    {
        return $this->belongsTo(PurchaseReceiving::class, 'pr_id', 'receiving_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
