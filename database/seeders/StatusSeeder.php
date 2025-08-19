<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('statuses')->insert([
            ['id' => 1, 'name' => 'Registered', 'description' => 'Sudah daftar, belum bayar booking.'],
            ['id' => 2, 'name' => 'Booking Paid', 'description' => 'Sudah bayar booking class.'],
            ['id' => 3, 'name' => 'Meeting Joined', 'description' => 'Sudah mengikuti meeting Google.'],
            ['id' => 5, 'name' => 'Active', 'description' => 'Kelas aktif dan berjalan.'],
            ['id' => 6, 'name' => 'Pemantapan', 'description' => 'Sedang menyiapkan berkas untuk berangkat ke Jepang'],
            ['id' => 7, 'name' => 'Pemberangkatan', 'description' => 'Siap berangkat ke Jepang'],
            ['id' => 8, 'name' => 'Verifikasi', 'description' => 'Akun belum aktif, menunggu verifikasi admin'],
        ]);
    }
}
