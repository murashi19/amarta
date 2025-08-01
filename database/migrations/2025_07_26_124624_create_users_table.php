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
        Schema::create('users', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->string('name', 100);
        $table->string('email', 150)->unique();
        $table->string('password', 255);
        $table->string('phone_number', 20)->nullable();
        $table->text('address')->nullable();
        $table->date('birth_date')->nullable();
        $table->string('education', 100)->nullable();
        $table->enum('japanese_level', ['N5', 'N4', 'N3', 'N2', 'N1', 'Belum Menguasai'])->nullable();
        $table->text('motivation')->nullable();
        $table->tinyInteger('status_id')->default(1);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
