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
        Schema::create('stock_adjustments', function (Blueprint $table) {
            $table->id('stock_a_id');
            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('restrict');
            $table->foreignId('product_stock_id')
                ->constrained('stocks', 'stock_id')
                ->onDelete('restrict');
            $table->integer('system_qty')->nullable();
            $table->integer('physical_qty')->nullable();
            $table->integer('difference')->nullable();
            $table->string('reason')->nullable();
            $table->foreignId('performed_by')
                ->constrained('users', 'user_id')
                ->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_adjustments');
    }
};
