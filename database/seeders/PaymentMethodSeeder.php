<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('payment_methods')->insert([
            ['bank_name' => 'BCA', 'account_number' => '1234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'bank_transfer'],
            ['bank_name' => 'MANDIRI', 'account_number' => '1380012345678', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'bank_transfer'],
            ['bank_name' => 'BRI', 'account_number' => '123456789012345', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'bank_transfer'],
            ['bank_name' => 'BNI', 'account_number' => '1234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'bank_transfer'],
            ['bank_name' => 'GOPAY', 'account_number' => '081234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'ewallet'],
            ['bank_name' => 'OVO', 'account_number' => '081234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'ewallet'],
            ['bank_name' => 'DANA', 'account_number' => '081234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'ewallet'],
            ['bank_name' => 'SHOPEEPAY', 'account_number' => '081234567890', 'account_name' => 'LPK Amarta Bangun Indonesia', 'type' => 'ewallet'],
        ]);
    }
}
