<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Data identitas
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number')->unique()->nullable();

            // Auth & verifikasi
            $table->string('password');
            $table->string('verification_code')->nullable();
            $table->timestamp('verification_expires_at')->nullable();
            $table->timestamp('last_otp_sent_at')->nullable();

            // Data pribadi
            $table->enum('gender', ['Laki-laki','Perempuan'])->nullable();
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->enum('education_level', [
                'SMP/Sederajat',
                'SMA/SMK/Sederajat',
                'Diploma 3 (D3)',
                'Sarjana (S1)',
                'Lainnya'
            ])->nullable();
            $table->string('photo')->nullable(); // cukup string, text terlalu besar

            // Relasi
            $table->foreignId('status_id')
                  ->nullable()
                  ->constrained('statuses')
                  ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
