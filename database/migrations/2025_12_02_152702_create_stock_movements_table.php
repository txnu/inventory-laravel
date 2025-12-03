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
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id('stock_m_id');
            $table->foreignId('product_id')
                ->constrained('products', 'product_id')
                ->onDelete('restrict');
            $table->foreignId('product_stock_id')
                ->constrained('stocks', 'stock_id')
                ->onDelete('restrict');
            $table->enum('movement_type', ['IN', 'OUT']);
            $table->string('reference_type');
            $table->bigInteger('reference_id');
            $table->integer('qty');
            $table->integer('before_qty')->nullable();
            $table->integer('after_qty')->nullable();
            $table->foreignId('created_by')
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
        Schema::dropIfExists('stock_movements');
    }
};
