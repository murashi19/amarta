<?php

// database/seeders/UserSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'AdminAmarta',
                'email' => 'adminamarta@gmail.com',
                'password' => Hash::make('password123'),
                'phone_number' => '081234567890',
                'address' => 'Jl. Merdeka No. 123, Jakarta Pusat',
                'birth_date' => '1990-05-15',
                'education' => 'S1 Teknik Informatika',
                'japanese_level' => 'N2',
                'motivation' => 'Ingin mengembangkan karir di bidang teknologi dan berkontribusi dalam industri IT.',
                'status_id' => 1, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rafli Afiw',
                'email' => 'rafli.afiw@gmail.com',
                'password' => Hash::make('rafliafiw123'),
                'phone_number' => '084567890123',
                'address' => 'Jl. Gatot Subroto No. 321, Medan',
                'birth_date' => '2005-03-10',
                'education' => 'SMA Negeri 1 Medan',
                'japanese_level' => 'Belum Menguasai',
                'motivation' => 'Baru mulai belajar bahasa Jepang dan tertarik dengan teknologi Jepang.',
                'status_id' => 1, // Active
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name' => 'Jane Smith',
            //     'email' => 'jane.smith@example.com',
            //     'password_hash' => Hash::make('password123'),
            //     'phone_number' => '083456789012',
            //     'status_id' => 1, // Active
            //     'address' => 'Jl. Diponegoro No. 789, Surabaya',
            //     'birth_date' => '1992-08-22',
            //     'education' => 'S1 Manajemen',
            //     'japanese_level' => 'N4',
            //     'motivation' => 'Ingin mengembangkan kemampuan bahasa Jepang untuk peluang karir internasional.',
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
