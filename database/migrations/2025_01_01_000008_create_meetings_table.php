<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('platform',50)->nullable();
            $table->string('meet_link');
            $table->string('zoom_meeting_id',100)->nullable();
            $table->string('zoom_passcode',50)->nullable();
            $table->dateTime('schedule_at');
            $table->boolean('is_attended')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('meetings');
    }
};
