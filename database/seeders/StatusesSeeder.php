<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusesSeeder extends Seeder {
    public function run(): void {
        DB::table('statuses')->insert([
            ['name'=>'Registered','description'=>'Sudah daftar, belum bayar booking.'],
            ['name'=>'Booking Paid','description'=>'Sudah bayar booking class.'],
            ['name'=>'Meeting Joined','description'=>'Sudah mengikuti meeting Google.'],
            ['name'=>'DP Paid','description'=>'Sudah membayar DP.'],
            ['name'=>'Active','description'=>'Kelas aktif dan berjalan.'],
            ['name'=>'Pemantapan','description'=>'Sedang menyiapkan berkas-berkas untuk berangkat ke Jepang'],
            ['name'=>'Pemberangkatan','description'=>'Siap berangkat ke Jepang'],
            ['name'=>'Verifikasi','description'=>'Akun Belum Aktif karena sedang dalam proses verifikasi akun'],
        ]);
    }
}
