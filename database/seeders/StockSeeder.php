<?php

namespace Database\Seeders;

use App\Models\Stock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stock::insert([
            [
                'product_id' => 1,
                'qty_on_hand' => 100,
                'qty_reserved' => 1,
            ]
        ]);
    }
}
