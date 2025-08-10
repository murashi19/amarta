<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Meeting;
use App\Models\User;

class MeetingSeeder extends Seeder
{
    public function run(): void
    {
        Meeting::create([
            'user_id' => User::first()->id,
            'meet_link' => 'https://meet.google.com/test-link',
            'schedule_at' => now()->addDays(1),
            'is_attended' => false,
        ]);
    }
}

