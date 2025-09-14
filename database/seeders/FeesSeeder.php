<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeesSeeder extends Seeder {
    public function run(): void {
        DB::table('fees')->insert([
            [
                'name' => 'Biaya Program Kelas',
                'type' => 'kelas_bahasa',
                'amount' => 7000000,
                'description' => 'Biaya pembelajaran bahasa Jepang level N5',
                'is_installment_available' => 1,
                'installment_amount' => 1000000,
                'installment_months' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Biaya Pemantapan',
                'type' => 'pemantapan',
                'amount' => 20000000,
                'description' => 'Biaya pelatihan intensif dan materi pembelajaran',
                'is_installment_available' => 0,
                'installment_amount' => null,
                'installment_months' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Biaya Pemberangkatan',
                'type' => 'pemberangkatan',
                'amount' => 35000000,
                'description' => 'Biaya tiket pesawat, visa, dan keperluan pemberangkatan',
                'is_installment_available' => 0,
                'installment_amount' => null,
                'installment_months' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Booking Class',
                'type' => 'booking',
                'amount' => 500000,
                'description' => 'Biaya booking kelas',
                'is_installment_available' => 0,
                'installment_amount' => null,
                'installment_months' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
