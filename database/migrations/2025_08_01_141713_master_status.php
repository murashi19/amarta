<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MasterStatus extends Migration
{
    public function up()
    {
        Schema::create('master_statuses', function (Blueprint $table) {
            $table->tinyIncrements('id'); // tinyint auto-increment
            $table->string('name', 50);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('master_statuses');
    }
}
