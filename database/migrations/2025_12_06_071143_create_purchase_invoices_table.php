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
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->foreignId('po_id')
                ->constrained('purchase_orders', 'po_id')
                ->onDelete('restrict');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->double('total_amount');
            $table->double('tax');
            $table->enum('status', ['unpaid', 'partial', 'paid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
