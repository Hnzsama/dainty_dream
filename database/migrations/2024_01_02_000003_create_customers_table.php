<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('m_customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('city', 100)->nullable();
            $table->string('phone', 20)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_customers');
    }
};
