<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReceiving extends Model
{
    use HasFactory;

    protected $table = 'purchase_receivings';
    protected $primaryKey = 'pr_id';

    protected $fillable = [
        'po_id',
        'receiving_code',
        'receiving_date',
        'receiving_by',
        'status',
    ];

    public function purchase_order()
    {
        return $this->belongsTo(PurchaseOrder::class, 'po_id', 'po_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'receiving_by', 'user_id');
    }

    public function items()
    {
        return $this->hasMany(PurchaseReceivingItems::class, 'pr_id', 'pr_id');
    }
}
