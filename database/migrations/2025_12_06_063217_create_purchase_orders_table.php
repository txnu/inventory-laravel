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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id('po_id');
            $table->string('po_code')->unique();
            $table->foreignId('supplier_id')
                ->constrained('suppliers', 'supplier_id')
                ->onDelete('restrict');;
            $table->date('order_date');
            $table->date('delivery_date');
            $table->enum('status', ['draft', 'ordered', 'received', 'closed', 'canceled'])->default('ordered');
            $table->string('notes');
            $table->decimal('total_amount', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
