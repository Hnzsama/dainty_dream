<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t_outgoing_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('m_products');
            $table->foreignId('customer_id')->constrained('m_customers');
            $table->integer('quantity');
            $table->date('transaction_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_outgoing_transactions');
    }
};
