<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('fee_id')->nullable();
            $table->enum('type', ['booking','dp','pemantapan','pemberangkatan','lunas']);
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['Pending','Completed','Failed','Verification'])->default('Pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('payment_schedule_id')->nullable();
            $table->date('due_date')->nullable();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('fee_id')->references('id')->on('fees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
