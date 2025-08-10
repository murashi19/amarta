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
        Schema::create('program_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_program_id');
            $table->decimal('booking_fee', 12, 2)->default(500000);
            $table->decimal('dp_fee', 12, 2)->default(7000000);
            $table->decimal('departure_fee', 12, 2)->default(7500000);
            $table->decimal('total_fee', 12, 2)->default(15000000);
            $table->timestamps();
            
            $table->foreign('class_program_id')->references('id')->on('class_programs')->onDelete('cascade');
            $table->index('class_program_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_fee');
    }
};
