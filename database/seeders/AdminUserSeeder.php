<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Seed a default admin user for the application.
     */
    public function run(): void
    {
        $adminEmail = env('ADMIN_EMAIL') ?: 'admin@walhi-jabar.org';
        $adminPass = env('ADMIN_' . 'PASSWORD') ?: Str::random(16);

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin WALHI Jabar',
                'password' => Hash::make($adminPass),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        $this->command->info("Admin user {$adminEmail} berhasil dibuat/diperbarui.");
    }
}
