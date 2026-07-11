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
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command->warn('ADMIN_EMAIL dan ADMIN_PASSWORD tidak di-set di file .env. AdminUserSeeder dilewati.');
            return;
        }

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin WALHI Jabar',
                'password' => Hash::make($password),
                'email_verified_at' => now(),
                'role' => 'admin', // Set explicitly to admin role
            ]
        );

        $this->command->info("Admin user {$email} berhasil dibuat/diperbarui.");
    }
}
