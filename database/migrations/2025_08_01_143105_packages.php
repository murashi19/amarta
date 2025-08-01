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
       Schema::create('packages', function (Blueprint $table) {
           $table->tinyIncrements('id');
            $table->string('name', 50);
            $table->decimal('price', 12, 2);
            $table->integer('duration_days');
            $table->integer('max_events');
            $table->integer('max_guests_per_event');
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('packages');
    }
};
