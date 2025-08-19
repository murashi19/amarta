<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'admin@amarta.test',
            'phone_number' => '081234567890',
            'password' => Hash::make('password123'), // ganti dengan password kuat
            'gender' => 'Laki-laki',
            'birth_place' => 'Bandung',
            'birth_date' => '2000-01-01',
            'address' => 'JL. Admin Utama',
            'education_level' => 'Sarjana (S1)',
            'status_id' => 5, // Active
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Hubungkan user ke role Admin
        DB::table('role_user')->insert([
            'user_id' => 1, // id user yang baru dibuat
            'role_id' => 1, // Admin
        ]);
    }
}
