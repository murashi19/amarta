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
       Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedTinyInteger('package_id')->nullable();
            $table->unsignedBigInteger('event_id')->nullable();
            $table->decimal('amount', 12, 2);
            $table->enum('type', ['Payment', 'Commission', 'Refund']);
            $table->enum('status', ['Pending', 'Completed', 'Failed']);
            $table->timestamps();

            // Foreign key constraints (optional but recommended)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('set null');
            $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
