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
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_code', 100);
            $table->foreignId('customer_id')
                ->constrained('customers', 'customer_id')
                ->onDelete('restrict');
            $table->date('order_date');
            $table->date('delivery_date')->nullable();
            $table->string('status', 50);
            $table->decimal('subtotal', 15, 2);
            $table->decimal('tax', 15, 2);
            $table->decimal('total', 15, 2);
            $table->string('payment_status', 50);
            $table->string('shipping_status', 50);
            $table->text('notes')->nullable();
            $table->foreignId('created_by')
                ->constrained('users', 'user_id')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales_orders');
    }
};
