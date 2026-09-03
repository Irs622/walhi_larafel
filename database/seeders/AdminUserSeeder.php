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

        $admin = User::firstOrNew(['email' => $adminEmail]);
        $admin->name = 'Admin WALHI Jabar';
        $admin->password = Hash::make($adminPass);
        $admin->email_verified_at = now();
        $admin->assignRole('admin');
        $admin->save();

        // ── Editor User ──
        $editorEmail = config('auth.editor_seed.email', 'editor@walhijabar.or.id');
        $editorPass = config('auth.editor_seed.password', 'WalhiEditor2026!');

        $editor = User::firstOrNew(['email' => $editorEmail]);
        $editor->name = 'Editor WALHI Jabar';
        $editor->password = Hash::make($editorPass);
        $editor->email_verified_at = now();
        $editor->assignRole('editor');
        $editor->save();

        if ($this->command) {
            $this->command->info("Admin user {$adminEmail} berhasil dibuat/diperbarui.");
            $this->command->info("Editor user {$editorEmail} berhasil dibuat/diperbarui.");
            if ($isGenerated && app()->environment('local')) {
                $this->command->warn("Password acak Admin dibuat: {$adminPass}");
            }
        }
    }
}
