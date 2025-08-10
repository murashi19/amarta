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
        DB::table('statuses')->insert([
            [
                'name' => 'Departure Paid',
                'description' => 'Sudah bayar biaya pemberangkatan, siap berangkat',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ready to Depart',
                'description' => 'Semua pembayaran lunas, siap berangkat ke Jepang',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('statuses')
            ->whereIn('name', ['Departure Paid', 'Ready to Depart'])
            ->delete();
    }
};
