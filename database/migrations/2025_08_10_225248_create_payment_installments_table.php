<?php

// database/migrations/2025_08_11_000001_create_payment_installments_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_order_id')->constrained('payment_orders')->onDelete('cascade');
            $table->integer('installment_number');
            $table->decimal('amount', 12, 2);
            $table->enum('status', ['pending','waiting_verification','paid','failed','expired'])->default('pending');
            $table->enum('payment_method', ['manual_transfer','bank_transfer','qris','credit_card','e_wallet'])->default('manual_transfer');
            $table->string('gateway_ref', 100)->nullable();
            $table->text('proof_photo')->nullable();
            $table->date('due_date');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_installments');
    }
};
