<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['kelas_bahasa','pemantapan','pemberangkatan','booking']);
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();
            $table->boolean('is_installment_available')->default(false);
            $table->decimal('installment_amount', 12, 2)->nullable();
            $table->integer('installment_months')->nullable();
            $table->timestamps();

            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};
