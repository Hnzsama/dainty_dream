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
        Schema::create('t_monthly_reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('incoming_total', 15, 2)->default(0);
            $table->decimal('outgoing_total', 15, 2)->default(0);
            $table->decimal('net_movement', 15, 2)->default(0);
            $table->integer('incoming_count')->default(0);
            $table->integer('outgoing_count')->default(0);
            $table->timestamps();
        });

        // Add foreign key to incoming_transactions
        Schema::table('t_incoming_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('monthly_report_id')->nullable();
            $table->foreign('monthly_report_id')->references('id')->on('t_monthly_reports')->onDelete('set null');
        });

        // Add foreign key to outgoing_transactions
        Schema::table('t_outgoing_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('monthly_report_id')->nullable();
            $table->foreign('monthly_report_id')->references('id')->on('t_monthly_reports')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign keys
        Schema::table('t_outgoing_transactions', function (Blueprint $table) {
            $table->dropForeign(['monthly_report_id']);
            $table->dropColumn('monthly_report_id');
        });

        Schema::table('t_incoming_transactions', function (Blueprint $table) {
            $table->dropForeign(['monthly_report_id']);
            $table->dropColumn('monthly_report_id');
        });

        Schema::dropIfExists('t_monthly_reports');
    }
};
