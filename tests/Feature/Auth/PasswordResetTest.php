<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_link_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_screen_can_be_rendered(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {
            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => 'Walhi2026#SecurePassword!9x',
                'password_confirmation' => 'Walhi2026#SecurePassword!9x',
            ]);

            $response
                ->assertSessionHasNoErrors()
                ->assertRedirect(route('login'));

            return true;
        });
    }

    public function test_reset_password_endpoint_is_rate_limited(): void
    {
        for ($i = 0; $i < 6; $i++) {
            $this->post('/reset-password', [
                'token' => 'dummy-token',
                'email' => 'test@example.com',
                'password' => 'Walhi2026#SecurePassword!9x',
                'password_confirmation' => 'Walhi2026#SecurePassword!9x',
            ]);
        }

        // The 7th attempt within the same minute should be rate limited (HTTP 429)
        $response = $this->post('/reset-password', [
            'token' => 'dummy-token',
            'email' => 'test@example.com',
            'password' => 'Walhi2026#SecurePassword!9x',
            'password_confirmation' => 'Walhi2026#SecurePassword!9x',
        ]);

        $response->assertStatus(429);
    }
}
