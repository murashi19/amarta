<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil user admin yang sudah ada
        $admin = Role::where('name', 'Admin')->first();
        if (!$admin) {
            $this->command->error('User admin tidak ditemukan. Pastikan sudah ada user dengan role admin.');
            return;
        }

        $announcements = [
            [
                'title' => 'Welcome - Pendaftaran Berhasil',
                'content' => 'Terimakasih sudah mendaftar di LPK Amarta, untuk selanjutnya anda harus membayar untuk Booking Class',
                'type' => 'auto_welcome',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'new_registrants',
                'has_payment_button' => true,
                'meet_link' => null,
                'views_count' => 45,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ],
            [
                'title' => 'Booking Class Berhasil',
                'content' => 'Selamat Anda telah berhasil Booking Class, untuk informasi selanjutnya mohon ditunggu untuk pengenalan LPK Amarta lewat Google Meet yang akan dikirim link lewat email anda',
                'type' => 'auto_booking_success',
                'status' => 'published',
                'priority' => 'high',
                'target_audience' => 'paid_students',
                'has_payment_button' => false,
                'meet_link' => 'https://meet.google.com/abc-defg-hij',
                'views_count' => 32,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(15)
            ],
            [
                'title' => 'Pengumuman Jadwal Kelas Februari',
                'content' => 'Jadwal kelas bahasa Jepang untuk bulan Februari telah tersedia. Silakan cek jadwal Anda di menu Kelas.',
                'type' => 'manual',
                'status' => 'draft',
                'priority' => 'medium',
                'target_audience' => 'all_students',
                'has_payment_button' => false,
                'meet_link' => null,
                'views_count' => 0,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10)
            ],
            [
                'title' => 'Info Libur Tahun Baru Imlek',
                'content' => 'Mohon diinformasikan bahwa LPK Amarta akan libur pada tanggal 29-31 Januari 2025 dalam rangka Tahun Baru Imlek.',
                'type' => 'manual',
                'status' => 'published',
                'priority' => 'low',
                'target_audience' => 'active_students',
                'has_payment_button' => false,
                'meet_link' => null,
                'views_count' => 75,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5)
            ],
            [
                'title' => 'Pembukaan Kelas Baru Bahasa Korea',
                'content' => 'Kami dengan senang hati mengumumkan pembukaan kelas baru untuk bahasa Korea. Pendaftaran dibuka mulai 1 Februari 2025.',
                'type' => 'manual',
                'status' => 'scheduled',
                'priority' => 'high',
                'target_audience' => 'all_students',
                'has_payment_button' => false,
                'meet_link' => null,
                'scheduled_at' => now()->addDays(3),
                'views_count' => 0,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2)
            ],
            [
                'title' => 'Workshop Public Speaking',
                'content' => 'Bergabunglah dalam workshop public speaking yang akan dilaksanakan pada hari Sabtu, 8 Februari 2025. Gratis untuk semua siswa aktif.',
                'type' => 'manual',
                'status' => 'draft',
                'priority' => 'medium',
                'target_audience' => 'active_students',
                'has_payment_button' => false,
                'meet_link' => 'https://meet.google.com/workshop-public-speaking',
                'views_count' => 0,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(1),
                'updated_at' => now()->subDays(1)
            ],
            [
                'title' => 'Evaluasi Kemajuan Siswa',
                'content' => 'Evaluasi kemajuan belajar akan dilaksanakan pada minggu ketiga setiap bulan. Mohon siswa mempersiapkan diri dengan baik.',
                'type' => 'manual',
                'status' => 'published',
                'priority' => 'medium',
                'target_audience' => 'active_students',
                'has_payment_button' => false,
                'meet_link' => null,
                'views_count' => 23,
                'created_by' => $admin->id,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7)
            ]
        ];

        foreach ($announcements as $announcement) {
            Announcement::create($announcement);
        }

        $this->command->info('Seeder pengumuman berhasil dijalankan.');
    }
}
