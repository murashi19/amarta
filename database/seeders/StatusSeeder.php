<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            ['name' => 'Registered',     'description' => 'Sudah daftar, belum bayar booking.'],
            ['name' => 'Booking Paid',   'description' => 'Sudah bayar booking class.'],
            ['name' => 'Meeting Joined', 'description' => 'Sudah mengikuti meeting Google.'],
            ['name' => 'DP Paid',        'description' => 'Sudah bayar DP, siap masuk kelas.'],
            ['name' => 'Active',         'description' => 'Kelas aktif dan berjalan.'],
        ];

        foreach ($statuses as $status) {
            Status::updateOrCreate(['name' => $status['name']], $status);
        }
    }
}

