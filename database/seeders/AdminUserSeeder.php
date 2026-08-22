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
        // ── Admin User ──
        $adminEmail = config('auth.admin_seed.email') ?: 'admin@walhijabar.or.id';
        $isGenerated = false;
        
        $adminPass = config('auth.admin_seed.password');
        if (empty($adminPass)) {
            $adminPass = Str::random(16);
            $isGenerated = true;
        }

        User::updateOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin WALHI Jabar',
                'password' => Hash::make($adminPass),
                'email_verified_at' => now(),
                'role' => 'admin',
            ]
        );

        // ── Editor User ──
        $editorEmail = config('auth.editor_seed.email', 'editor@walhijabar.or.id');
        $editorPass = config('auth.editor_seed.password', 'WalhiEditor2026!');

        User::updateOrCreate(
            ['email' => $editorEmail],
            [
                'name' => 'Editor WALHI Jabar',
                'password' => Hash::make($editorPass),
                'email_verified_at' => now(),
                'role' => 'editor',
            ]
        );

        if ($this->command) {
            $this->command->info("Admin user {$adminEmail} berhasil dibuat/diperbarui.");
            $this->command->info("Editor user {$editorEmail} berhasil dibuat/diperbarui.");
            if ($isGenerated && app()->environment('local')) {
                $this->command->warn("Password acak Admin dibuat: {$adminPass}");
            }
        }
    }
}
