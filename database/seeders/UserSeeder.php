<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
                'birth_place' => 'Jakarta',
                'birth_date' => '1990-05-15',
                'education_level' => 'S1 Teknik Informatika',
                'status_id' => 1,
                'is_verified' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rafli Afiw',
                'email' => 'rafli.afiw@gmail.com',
                'password' => Hash::make('rafliafiw123'),
                'phone_number' => '084567890123',
                'address' => 'Jl. Moch Toha No. 31, Kota Bandung',
                'birth_place' => 'Bandung',
                'birth_date' => '2005-03-10',
                'education_level' => 'SMA Negeri 1 Bandung',
                'status_id' => 1,
                'is_verified' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
