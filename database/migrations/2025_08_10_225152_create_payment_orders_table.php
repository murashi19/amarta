<?php

// database/migrations/2025_08_11_000000_create_payment_orders_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payment_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('fee_id')->nullable()->constrained('fees')->onDelete('set null');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->enum('type', ['booking','dp','pemantapan','pemberangkatan','program_kelas']);
            $table->decimal('total_amount', 12, 2);
            $table->decimal('amount', 12, 2);
            $table->boolean('is_installment')->default(false);
            $table->integer('installment_months')->nullable();
            $table->enum('status', ['pending','waiting_verification','paid','failed','expired'])->default('pending');
            $table->enum('payment_method', ['manual_transfer','bank_transfer','qris','credit_card','e_wallet'])->default('manual_transfer');
            $table->string('gateway_ref', 100)->nullable();
            $table->text('proof_photo')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_orders');
    }
};

