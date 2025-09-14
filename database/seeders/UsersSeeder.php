<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder {
    public function run(): void {
        DB::table('users')->insertGetId([
            'name' => 'Super Admin Amarta',
            'email' => 'ainadanshidiq@gmail.com',
            'phone_number' => '082134716388',
            'password' => Hash::make('rafli123'),
            'status_id' => 5,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }
}
