<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['umum','auto welcome','auto booking success','auto dp request','auto installment','auto success'])->default('umum');
            $table->enum('status', ['draft','published','scheduled'])->default('draft');
            $table->enum('priority', ['low','medium','high'])->default('medium');
            $table->enum('target_audience', ['all students','new registrants','paid students','active students','dp paid','meeting joined'])->default('all students');
            $table->boolean('has_payment_button')->default(false);
            $table->string('meet_link')->nullable();
            $table->dateTime('scheduled_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(1);
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['status','type']);
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};


