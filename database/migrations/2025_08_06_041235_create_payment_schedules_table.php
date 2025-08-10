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
       Schema::create('payment_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('class_program_id');
            $table->enum('payment_type', ['booking', 'dp', 'departure']);
            $table->date('due_date');
            $table->decimal('amount', 12, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('class_program_id')->references('id')->on('class_programs')->onDelete('cascade');
            
            // Unique constraint: satu user hanya punya satu schedule per payment type per program
            $table->unique(['user_id', 'payment_type', 'class_program_id'], 'unique_user_payment_type');
            
            // Indexes untuk performa
            $table->index(['user_id', 'payment_type']);
            $table->index('due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_schedules');
    }
};
