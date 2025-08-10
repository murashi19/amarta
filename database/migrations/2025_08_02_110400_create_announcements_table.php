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
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['manual', 'auto_welcome', 'auto_booking_success'])->default('manual');
            $table->enum('status', ['draft', 'published', 'scheduled'])->default('draft');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('target_audience', ['all_students', 'new_registrants', 'paid_students', 'active_students'])->default('all_students');
            $table->boolean('has_payment_button')->default(false);
            $table->string('meet_link')->nullable();
            $table->datetime('scheduled_at')->nullable();
            $table->integer('views_count')->default(0);
            $table->unsignedBigInteger('created_by');
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status', 'type']);
            $table->index('scheduled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};