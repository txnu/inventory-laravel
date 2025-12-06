<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    use HasFactory;

    protected $table = 'purchase_invoices';
    protected $primaryKey = 'invoice_id';

    protected $fillable = [
        'po_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'total_amount',
        'tax',
        'status',
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'po_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
