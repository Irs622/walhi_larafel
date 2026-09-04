<?php

namespace App\Console\Commands;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'walhi:create-admin
                            {--name= : Nama lengkap admin}
                            {--email= : Alamat email atau username}
                            {--password= : Password untuk akun baru}
                            {--role=admin : Peran user (admin atau editor)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Membuat akun administrator atau editor baru secara aman via CLI/VPS';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('───────────────────────────────────────────────────────');
        $this->info('  🌿 WALHI Jawa Barat — Pembuatan Akun Administrator');
        $this->info('───────────────────────────────────────────────────────');

        $name = $this->option('name') ?: $this->ask('Nama Lengkap');
        while (empty($name)) {
            $this->error('Nama wajib diisi.');
            $name = $this->ask('Nama Lengkap');
        }

        $emailInput = $this->option('email') ?: $this->ask('Email atau Username (misal: nama atau nama@walhijabar.or.id)');
        while (empty($emailInput)) {
            $this->error('Email atau Username wajib diisi.');
            $emailInput = $this->ask('Email atau Username');
        }

        $email = trim($emailInput);
        if (! str_contains($email, '@')) {
            $email = Str::lower($email) . '@walhijabar.or.id';
        }

        $role = $this->option('role');
        if (! in_array($role, ['admin', 'editor'], true)) {
            $role = $this->choice('Pilih Peran Akun', ['admin', 'editor'], 0);
        }

        $password = $this->option('password');
        if (empty($password)) {
            $password = $this->secret('Password (minimal 8 karakter)');
            while (empty($password) || strlen($password) < 8) {
                $this->error('Password minimal harus 8 karakter.');
                $password = $this->secret('Password (minimal 8 karakter)');
            }
        }

        $user = User::firstOrNew(['email' => $email]);
        $isNew = ! $user->exists;

        $user->name = $name;
        $user->password = Hash::make($password);
        $user->email_verified_at = $user->email_verified_at ?: now();
        $user->assignRole($role === 'editor' ? UserRole::Editor : UserRole::Admin);
        $user->save();

        $actionText = $isNew ? 'berhasil dibuat' : 'berhasil diperbarui';
        $this->newLine();
        $this->info("✅ Akun {$role} {$name} ({$email}) {$actionText}!");
        $this->line("   Login URL : " . url('/login'));
        $this->line("   Username  : " . explode('@', $email)[0]);
        $this->line("   Email     : {$email}");
        $this->newLine();

        return self::SUCCESS;
    }
}
