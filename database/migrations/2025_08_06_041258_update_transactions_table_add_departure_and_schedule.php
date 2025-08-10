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
        Schema::table('transactions', function (Blueprint $table) {
            // Update enum type untuk include departure
            DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('booking','dp','departure') NOT NULL");
            
            // Tambah kolom baru
            $table->unsignedBigInteger('payment_schedule_id')->nullable()->after('user_id');
            $table->date('due_date')->nullable()->after('amount');
            
            // Foreign key
            $table->foreign('payment_schedule_id')->references('id')->on('payment_schedules')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
            Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['payment_schedule_id']);
            $table->dropColumn(['payment_schedule_id', 'due_date']);
            
            // Rollback enum
            DB::statement("ALTER TABLE transactions MODIFY COLUMN type ENUM('booking','dp') NOT NULL");
        });
    }
};
