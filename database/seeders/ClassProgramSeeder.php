<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassProgram;

class ClassProgramSeeder extends Seeder
{
    public function run(): void
    {
        ClassProgram::create([
            'name' => 'Kelas Bahasa Jepang N5',
            'description' => 'Kelas pemula bahasa Jepang',
            'start_date' => now()->addDays(3),
            'end_date' => now()->addMonths(3),
        ]);
    }
}

