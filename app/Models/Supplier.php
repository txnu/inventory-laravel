<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class supplier extends Model
{
    /** @use HasFactory<\Database\Factories\SupplierFactory> */
    use HasFactory;

    protected $table = 'suppliers';
    protected $primaryKey = 'supplier_id';

    protected $fillable = [
        'supplier_name',
        'contact_name',
        'email',
        'phone',
        'address',
        'status'
    ];
}
