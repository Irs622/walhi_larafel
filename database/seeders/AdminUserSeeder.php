<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed a default admin user for the application.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@walhi-jabar.org'],
            [
                'name' => 'Admin WALHI Jabar',
                'password' => Hash::make('walhi@2026!secure'),
                'email_verified_at' => now(),
            ]
        );
    }
}
