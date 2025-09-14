<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsSeeder extends Seeder {
    public function run(): void {
        DB::table('payment_methods')->insert([
            ['bank_name'=>'MANDIRI','account_number'=>'1560003918101','account_name'=>'LPK Amarta Bangun  Cabang Cibitung','type'=>'bank_transfer'],
            ['bank_name'=>'CASH','account_number'=>'Ke Kantor : Perumahan Gramapuri Persada, Blok E5, NO.01, Ds.Sukajaya, Kec. Cibitung Kab. Bekasi-Jawa Barat','account_name'=>'LPK Amarta Bangun Indonesia','type'=>'cash'],
        ]);
    }
}
