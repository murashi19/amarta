<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use App\Models\User;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'booking',
            'amount' => 50000,
            'status' => 'completed',
            'proof_url' => 'https://example.com/bukti-booking.jpg',
        ]);

        Transaction::create([
            'user_id' => $user->id,
            'type' => 'dp',
            'amount' => 2500000,
            'status' => 'completed',
            'proof_url' => 'https://example.com/bukti-dp.jpg',
        ]);
    }
}
