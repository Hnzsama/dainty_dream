<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 100)->unique();
            $table->string('name');
            $table->foreignId('category_id')->constrained('m_categories');
            $table->foreignId('supplier_id')->constrained('m_suppliers');
            $table->string('condition_status', 50)->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_products');
    }
};
