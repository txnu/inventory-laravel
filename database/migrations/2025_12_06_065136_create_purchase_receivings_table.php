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
        Schema::create('purchase_receivings', function (Blueprint $table) {
            $table->id('pr_id');
            $table->foreignId('po_id')
                ->constrained('purchase_orders', 'po_id')
                ->onDelete('restrict');
            $table->string('receiving_code');
            $table->date('receiving_date');
            $table->foreignId('receiving_by')
                ->constrained('users', 'user_id')
                ->onDelete('restrict');
            $table->enum('status', ['partial', 'completed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_receivings');
    }
};
