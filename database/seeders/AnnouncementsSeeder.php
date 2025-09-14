<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnnouncementsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('announcements')->insert([
            // Auto Pesan Sistem
            [
                'title' => 'Welcome - Pendaftaran Berhasil',
                'content' => 'Terimakasih sudah mendaftar di LPK Amarta, silakan lakukan pembayaran Booking Class untuk melanjutkan.',
                'type' => 'auto welcome',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'new registrants',
                'has_payment_button' => 1,
                'meet_link' => null,
                'scheduled_at' => null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Booking Class Berhasil',
                'content' => 'Selamat! Anda berhasil melakukan booking class. Mohon tunggu jadwal pengenalan melalui Google Meet atau Zoom.',
                'type' => 'auto booking success',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'paid students',
                'has_payment_button' => 0,
                'meet_link' => null,
                'scheduled_at' => Carbon::now()->addDays(3),
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Permintaan DP Program Kelas',
                'content' => 'Silakan segera melakukan pembayaran DP Program Kelas agar kelas Anda dapat diaktifkan.',
                'type' => 'auto dp request',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'meeting joined',
                'has_payment_button' => 1,
                'meet_link' => null,
                'scheduled_at' => null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Selamat Kelas Anda Aktif',
                'content' => 'Kelas Anda sudah aktif. Jangan lupa melunasi biaya kelas dan ikuti semua jadwal pembelajaran tepat waktu.',
                'type' => 'auto installment',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'active students',
                'has_payment_button' => 1,
                'meet_link' => '',
                'scheduled_at' => null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pembayaran Sukses',
                'content' => 'Pembayaran Anda telah berhasil diverifikasi. Terima kasih telah membayar tepat waktu.',
                'type' => 'auto success',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'dp paid',
                'has_payment_button' => 0,
                'meet_link' => null,
                'scheduled_at' => null,
                'created_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
