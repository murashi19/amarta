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
            $table->index(['user_id', 'type'], 'idx_transactions_user_type');
            $table->index('status', 'idx_transactions_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_user_type');
            $table->dropIndex('idx_transactions_status');
        });
    }
};
