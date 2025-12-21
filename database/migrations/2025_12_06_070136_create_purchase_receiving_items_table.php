<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_receiving_items', function (Blueprint $table) {
            $table->id('pr_item_id');
            $table->foreignId('pr_id')
                ->constrained('purchase_receivings', 'pr_id')
                ->onDelete('restrict');
            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('restrict');
            $table->integer('qty_received');
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receiving_items');
    }
};
