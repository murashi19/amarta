<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ClassProgram;

class UserClassSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $class = ClassProgram::first();

        $user->classes()->attach($class->id, [
            'enrolled_at' => now(),
        ]);
    }
}

