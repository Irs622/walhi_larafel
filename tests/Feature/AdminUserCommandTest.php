<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_command_creates_admin_user_with_strong_password(): void
    {
        $this->artisan('walhi:create-admin', [
            '--name' => 'Super Administrator',
            '--email' => 'admin@walhijabar.or.id',
            '--role' => 'admin',
        ])
            ->expectsQuestion('Password (min. 12 karakter, huruf besar/kecil, angka, simbol)', 'WalhiJabar#2026Secure!')
            ->expectsQuestion('Ulangi Password', 'WalhiJabar#2026Secure!')
            ->assertSuccessful();

        $user = User::where('email', 'admin@walhijabar.or.id')->first();
        $this->assertNotNull($user);
        $this->assertSame('Super Administrator', $user->name);
        $this->assertTrue($user->isAdmin());
        $this->assertTrue(Hash::check('WalhiJabar#2026Secure!', $user->password));
    }

    public function test_command_rejects_weak_password_and_prompts_until_valid(): void
    {
        $this->artisan('walhi:create-admin', [
            '--name' => 'Editor User',
            '--email' => 'editor@walhijabar.or.id',
            '--role' => 'editor',
        ])
            // First attempt: weak password
            ->expectsQuestion('Password (min. 12 karakter, huruf besar/kecil, angka, simbol)', 'weak')
            ->expectsQuestion('Ulangi Password', 'weak')
            // Second attempt: valid strong password
            ->expectsQuestion('Password (min. 12 karakter, huruf besar/kecil, angka, simbol)', 'WalhiEditor#2026Secure!')
            ->expectsQuestion('Ulangi Password', 'WalhiEditor#2026Secure!')
            ->assertSuccessful();

        $user = User::where('email', 'editor@walhijabar.or.id')->first();
        $this->assertNotNull($user);
        $this->assertTrue($user->isEditor());
        $this->assertTrue(Hash::check('WalhiEditor#2026Secure!', $user->password));
    }

    public function test_command_rejects_password_confirmation_mismatch(): void
    {
        $this->artisan('walhi:create-admin', [
            '--name' => 'Mismatch User',
            '--email' => 'mismatch@walhijabar.or.id',
            '--role' => 'admin',
        ])
            // First attempt: mismatched confirmation
            ->expectsQuestion('Password (min. 12 karakter, huruf besar/kecil, angka, simbol)', 'WalhiJabar#2026Secure!')
            ->expectsQuestion('Ulangi Password', 'DifferentPassword#123')
            // Second attempt: matching valid password
            ->expectsQuestion('Password (min. 12 karakter, huruf besar/kecil, angka, simbol)', 'WalhiJabar#2026Secure!')
            ->expectsQuestion('Ulangi Password', 'WalhiJabar#2026Secure!')
            ->assertSuccessful();

        $user = User::where('email', 'mismatch@walhijabar.or.id')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('WalhiJabar#2026Secure!', $user->password));
    }
}
