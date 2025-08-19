<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->string('payment_method', 100)->nullable();
            $table->string('selected_method', 50)->nullable();
            $table->text('amount');
            $table->integer('installment_number')->nullable();
            $table->enum('status', ['Pending','Completed','Verification','Failed'])->default('Pending');
            $table->text('photo')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference_number', 100)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['transaction_id','status']);
            $table->index('payment_method');
            $table->index('reference_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fee_payments');
    }
};
