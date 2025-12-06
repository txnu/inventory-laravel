<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchasePayment extends Model
{
    use HasFactory;

    protected $table = 'purchase_payments';
    protected $primaryKey = 'payment_id';

    protected $fillable = [
        'invoice_id',
        'payment_date',
        'amount_paid',
        'method',
        'reference',
    ];

    public function purchase_invoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'invoice_id', 'invoice_id');
    }
}
