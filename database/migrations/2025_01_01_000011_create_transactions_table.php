<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('fee_id')->nullable()->constrained('fees');
            $table->enum('type',['booking','dp','pemantapan','pemberangkatan','lunas']);
            $table->decimal('amount',12,2);
            $table->enum('status',['Pending','Completed','Failed','Verification'])->default('Pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('payment_schedule_id')->nullable();
            $table->date('due_date')->nullable();
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
    }
};
