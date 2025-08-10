<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
        StatusSeeder::class,
        RoleSeeder::class,
        UserSeeder::class,
        ClassProgramSeeder::class,
        UserClassSeeder::class,
        MeetingSeeder::class,
        TransactionSeeder::class,
        NotificationSeeder::class,
        AnnouncementSeeder::class
    ]);
    }
}
