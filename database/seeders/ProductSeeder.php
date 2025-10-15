<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'sku' => 'PRD001',
                'product_name' => 'Kopi Arabica',
                'description' => 'Kopi dengan aroma yang khas',
                'purchase_price' => 20000,
                'selling_price' => 25000,
                'barcode' => '1234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'sku' => 'PRD002',
                'product_name' => 'Kopi Luwak',
                'description' => 'Kopi dengan pengolahan terbaik',
                'purchase_price' => 28000,
                'selling_price' => 40000,
                'barcode' => '0987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
