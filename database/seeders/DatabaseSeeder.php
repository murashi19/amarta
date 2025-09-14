<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            
            StatusesSeeder::class,
            UsersSeeder::class,
            RolesSeeder::class,
            Role_UsersSeeder::class,
            AnnouncementsSeeder::class,
            FeesSeeder::class,
            PaymentMethodsSeeder::class,
            
        ]);
    }
}
