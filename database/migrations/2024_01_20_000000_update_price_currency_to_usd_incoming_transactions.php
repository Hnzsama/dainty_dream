<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('t_incoming_transactions', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change()->comment('Price in USD (Dollar)');
        });
    }

    public function down(): void
    {
        Schema::table('t_incoming_transactions', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->change()->comment('Price in Rupiah');
        });
    }
};
