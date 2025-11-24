<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create CEO
        $ceo = User::create([
            'name' => 'John CEO',
            'email' => 'ceo@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $ceo->assignRole('ceo');

        // Create Finance Manager
        $fm = User::create([
            'name' => 'Jane Finance',
            'email' => 'finance@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $fm->assignRole('finance_manager');

        // Create Staff
        $staff = User::create([
            'name' => 'Bob Staff',
            'email' => 'staff@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $staff->assignRole('staff');
    }
}
