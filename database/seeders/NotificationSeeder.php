<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        Notification::create([
            'user_id' => User::first()->id,
            'type' => 'email',
            'content' => 'Link meeting sudah dikirim ke email Anda.',
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }
}

