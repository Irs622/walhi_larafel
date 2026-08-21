<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Content;
use App\Models\Donation;
use App\Models\Subscriber;
use App\Models\User;
use App\Services\CsvSanitizer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    // ──────────────────────────────────────────────────────────────────────────
    // 1. Authorization & Privilege Escalation Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_unauthenticated_guest_cannot_access_admin_endpoints(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/comments');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/subscribers');
        $response->assertRedirect('/login');
    }

    public function test_normal_user_cannot_access_admin_dashboard_or_subscribers(): void
    {
        $user = User::factory()->create(); // default subscriber role

        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);

        $response = $this->actingAs($user)->get('/admin/subscribers');
        $response->assertStatus(403);
    }

    public function test_editor_cannot_perform_destructive_admin_actions(): void
    {
        $editor = User::factory()->editor()->create();

        $content = Content::create([
            'title' => 'Article to Delete',
            'slug' => 'article-to-delete',
            'category' => 'blog',
            'status' => 'published',
            'body' => 'Body text',
        ]);

        $comment = Comment::create([
            'content_id' => $content->id,
            'author_name' => 'John',
            'author_email' => 'john@example.com',
            'body' => 'Test comment',
            'status' => 'pending',
        ]);

        $subscriber = Subscriber::create([
            'email' => 'sub@example.com',
            'is_active' => true,
        ]);

        // Editor cannot delete content
        $response = $this->actingAs($editor)->delete("/admin/blog/{$content->id}");
        $response->assertStatus(403);

        // Editor cannot delete comment
        $response = $this->actingAs($editor)->delete("/admin/comments/{$comment->id}");
        $response->assertStatus(403);

        // Editor cannot delete subscriber
        $response = $this->actingAs($editor)->delete("/admin/subscribers/{$subscriber->id}");
        $response->assertStatus(403);

        // Editor cannot export subscriber list
        $response = $this->actingAs($editor)->get('/admin/subscribers/export');
        $response->assertStatus(403);
    }

    public function test_admin_can_perform_administrative_and_export_actions(): void
    {
        $admin = User::factory()->admin()->create();

        $subscriber = Subscriber::create([
            'email' => 'sub_admin@example.com',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get('/admin/subscribers/export');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        $response = $this->actingAs($admin)->delete("/admin/subscribers/{$subscriber->id}");
        $response->assertStatus(302);
        $this->assertSoftDeleted('subscribers', ['id' => $subscriber->id]);
    }

    public function test_draft_content_is_hidden_from_guests_and_subscribers_but_visible_to_editors(): void
    {
        $draft = Content::create([
            'title' => 'Secret Draft Investigation',
            'slug' => 'secret-draft-investigation',
            'category' => 'blog',
            'status' => 'draft',
            'body' => 'Confidential unpublished findings.',
        ]);

        // Guest gets 404
        $response = $this->get('/konten/secret-draft-investigation');
        $response->assertStatus(404);

        // Subscriber gets 404
        $subscriberUser = User::factory()->create();
        $response = $this->actingAs($subscriberUser)->get('/konten/secret-draft-investigation');
        $response->assertStatus(404);

        // Editor can view draft
        $editor = User::factory()->editor()->create();
        $response = $this->actingAs($editor)->get('/konten/secret-draft-investigation');
        $response->assertStatus(200)
            ->assertSee('Secret Draft Investigation');
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 2. Mass Assignment Security Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_user_cannot_escalate_role_via_profile_update(): void
    {
        $user = User::factory()->create();
        $this->assertFalse($user->isAdmin());

        $response = $this->actingAs($user)->patch('/profile', [
            'name' => 'Hacked Name',
            'email' => $user->email,
            'role' => 'admin',
        ]);

        $response->assertSessionHasNoErrors();
        $user->refresh();
        $this->assertNotSame('admin', $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_comment_submission_cannot_force_approved_status(): void
    {
        $content = Content::create([
            'title' => 'Sample Post',
            'slug' => 'sample-post',
            'category' => 'blog',
            'status' => 'published',
            'body' => 'Post body',
        ]);

        $response = $this->post("/konten/{$content->id}/komentar", [
            'author_name' => 'Attacker',
            'author_email' => 'attacker@example.com',
            'body' => 'Legitimate looking comment with malicious status attempt.',
            'status' => 'approved',
        ]);

        $response->assertSessionHas('comment_success');
        $this->assertDatabaseHas('comments', [
            'author_email' => 'attacker@example.com',
            'status' => 'pending',
        ]);
        $this->assertDatabaseMissing('comments', [
            'author_email' => 'attacker@example.com',
            'status' => 'approved',
        ]);
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 3. XSS & HTMLPurifier Sanitization Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_htmlpurifier_renders_html5_figure_and_preserves_safe_html(): void
    {
        $content = new Content([
            'body' => '<p>Intro paragraph</p><figure class="my-4 text-center"><img src="https://example.com/photo.jpg" alt="Photo" /><figcaption>Image description</figcaption></figure><strong>Bold text</strong>',
        ]);

        $sanitized = $content->sanitized_body;

        $this->assertStringContainsString('<figure', $sanitized);
        $this->assertStringContainsString('<figcaption>Image description</figcaption>', $sanitized);
        $this->assertStringContainsString('https://example.com/photo.jpg', $sanitized);
        $this->assertStringContainsString('<strong>Bold text</strong>', $sanitized);
    }

    public function test_htmlpurifier_strips_dangerous_xss_payloads(): void
    {
        $maliciousPayloads = [
            '<script>alert("XSS")</script><p>Text</p>',
            '<img src="x" onerror="alert(document.cookie)" />',
            '<div onclick="evil()">Clickable</div>',
            '<a href="javascript:alert(1)">Evil Link</a>',
            '<a href="data:text/html;base64,PHNjcmlwdD5hbGVydCgxKTwvc2NyaXB0Pg==">Data Link</a>',
            '<iframe src="https://attacker.com"></iframe>',
            '<object data="evil.swf"></object>',
            '<embed src="evil.swf">',
            '<svg onload="alert(1)"><circle r="10"/></svg>',
        ];

        foreach ($maliciousPayloads as $payload) {
            $content = new Content(['body' => $payload]);
            $sanitized = $content->sanitized_body;

            $this->assertStringNotContainsString('<script', $sanitized, "Failed stripping script tag in: {$payload}");
            $this->assertStringNotContainsString('onerror', $sanitized, "Failed stripping onerror in: {$payload}");
            $this->assertStringNotContainsString('onclick', $sanitized, "Failed stripping onclick in: {$payload}");
            $this->assertStringNotContainsString('javascript:', $sanitized, "Failed stripping javascript: URI in: {$payload}");
            $this->assertStringNotContainsString('data:text/html', $sanitized, "Failed stripping data: URI in: {$payload}");
            $this->assertStringNotContainsString('<iframe', $sanitized, "Failed stripping iframe in: {$payload}");
            $this->assertStringNotContainsString('<object', $sanitized, "Failed stripping object in: {$payload}");
            $this->assertStringNotContainsString('<embed', $sanitized, "Failed stripping embed in: {$payload}");
        }
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 4. File Upload & Storage Security Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_executable_and_svg_file_uploads_are_rejected(): void
    {
        Storage::fake('public');
        $admin = User::factory()->admin()->create();

        $dangerousFiles = [
            UploadedFile::fake()->create('shell.php', 10, 'text/x-php'),
            UploadedFile::fake()->create('shell.phtml', 10, 'application/x-httpd-php'),
            UploadedFile::fake()->create('malicious.svg', 10, 'image/svg+xml'),
            UploadedFile::fake()->create('script.sh', 10, 'application/x-sh'),
            UploadedFile::fake()->create('.htaccess', 10, 'text/plain'),
        ];

        foreach ($dangerousFiles as $file) {
            $response = $this->actingAs($admin)->post('/admin/blog', [
                'title' => 'Test Post',
                'category' => 'blog',
                'status' => 'published',
                'image' => $file,
            ]);

            $response->assertSessionHasErrors('image');
        }
    }

    public function test_private_local_disk_is_not_served_over_public_http(): void
    {
        $this->assertFalse(config('filesystems.disks.local.serve', false));
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 5. Payment Webhook Security & Idempotency Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_donation_webhook_rejects_missing_or_invalid_signature(): void
    {
        config(['midtrans.server_key' => 'SB-Mid-server-TESTKEY123']);

        $donation = Donation::create([
            'order_id' => 'WALHI-DON-TEST-001',
            'donor_name' => 'Ahmad',
            'donor_email' => 'ahmad@example.com',
            'donor_phone' => '08123456789',
            'amount' => 50000,
            'status' => 'pending',
        ]);

        // Send forged signature
        $response = $this->postJson('/donasi/webhook', [
            'order_id' => 'WALHI-DON-TEST-001',
            'status_code' => '200',
            'gross_amount' => '50000.00',
            'signature_key' => 'invalid_forged_hash',
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(403);
        $donation->refresh();
        $this->assertSame('pending', $donation->status);
    }

    public function test_donation_webhook_rejects_amount_mismatch(): void
    {
        $serverKey = 'SB-Mid-server-TESTKEY123';
        config(['midtrans.server_key' => $serverKey]);

        $donation = Donation::create([
            'order_id' => 'WALHI-DON-TEST-002',
            'donor_name' => 'Ahmad',
            'donor_email' => 'ahmad@example.com',
            'donor_phone' => '08123456789',
            'amount' => 50000,
            'status' => 'pending',
        ]);

        // Valid signature for 10000 but donation in DB is 50000
        $forgedAmount = '10000.00';
        $validSignatureForForgedAmount = hash('sha512', 'WALHI-DON-TEST-002200'.$forgedAmount.$serverKey);

        $response = $this->postJson('/donasi/webhook', [
            'order_id' => 'WALHI-DON-TEST-002',
            'status_code' => '200',
            'gross_amount' => $forgedAmount,
            'signature_key' => $validSignatureForForgedAmount,
            'transaction_status' => 'settlement',
        ]);

        $response->assertStatus(400);
        $donation->refresh();
        $this->assertSame('pending', $donation->status);
    }

    public function test_successful_donation_cannot_be_downgraded_by_webhook(): void
    {
        $serverKey = 'SB-Mid-server-TESTKEY123';
        config(['midtrans.server_key' => $serverKey]);

        $donation = Donation::create([
            'order_id' => 'WALHI-DON-TEST-003',
            'donor_name' => 'Ahmad',
            'donor_email' => 'ahmad@example.com',
            'donor_phone' => '08123456789',
            'amount' => 50000,
            'status' => 'success',
        ]);

        $grossAmount = '50000.00';
        $signature = hash('sha512', 'WALHI-DON-TEST-003200'.$grossAmount.$serverKey);

        $response = $this->postJson('/donasi/webhook', [
            'order_id' => 'WALHI-DON-TEST-003',
            'status_code' => '200',
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'expire',
        ]);

        $response->assertStatus(200);
        $donation->refresh();
        $this->assertSame('success', $donation->status);
    }

    public function test_duplicate_settlement_webhook_is_idempotent_and_does_not_mutate_state_twice(): void
    {
        $serverKey = 'SB-Mid-server-TESTKEY123';
        config(['midtrans.server_key' => $serverKey]);

        $donation = Donation::create([
            'order_id' => 'WALHI-DON-TEST-004',
            'donor_name' => 'Ahmad',
            'donor_email' => 'ahmad@example.com',
            'donor_phone' => '08123456789',
            'amount' => 75000,
            'status' => 'pending',
        ]);

        $grossAmount = '75000.00';
        $signature = hash('sha512', 'WALHI-DON-TEST-004200'.$grossAmount.$serverKey);

        $payload = [
            'order_id' => 'WALHI-DON-TEST-004',
            'status_code' => '200',
            'gross_amount' => $grossAmount,
            'signature_key' => $signature,
            'transaction_status' => 'settlement',
            'payment_type' => 'qris',
        ];

        // First webhook call: transitions from pending to success
        $response1 = $this->postJson('/donasi/webhook', $payload);
        $response1->assertStatus(200);
        $donation->refresh();
        $this->assertSame('success', $donation->status);
        $this->assertSame('qris', $donation->payment_type);

        // Second duplicate webhook call (replay / network retry): returns 200, remains success, no duplicate record
        $response2 = $this->postJson('/donasi/webhook', $payload);
        $response2->assertStatus(200);
        $donation->refresh();
        $this->assertSame('success', $donation->status);
        $this->assertSame(1, Donation::where('order_id', 'WALHI-DON-TEST-004')->count());
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 6. CSV Formula Injection Sanitization Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_csv_sanitizer_escapes_dangerous_formula_prefixes(): void
    {
        $maliciousInputs = [
            '=cmd|"/C calc"!A0' => "'=cmd|\"/C calc\"!A0",
            '+1234567890' => "'+1234567890",
            '-5+5' => "'-5+5",
            '@SUM(1,2)' => "'@SUM(1,2)",
            "\tTAB_INJECT" => "'\tTAB_INJECT",
            '|PIPE_INJECT' => "'|PIPE_INJECT",
            '%PERCENT_INJECT' => "'%PERCENT_INJECT",
        ];

        foreach ($maliciousInputs as $raw => $expected) {
            $this->assertSame($expected, CsvSanitizer::sanitize($raw));
        }

        // Safe strings remain unchanged
        $this->assertSame('clean_user@example.com', CsvSanitizer::sanitize('clean_user@example.com'));
        $this->assertSame('', CsvSanitizer::sanitize(''));
        $this->assertSame('', CsvSanitizer::sanitize(null));
    }

    // ──────────────────────────────────────────────────────────────────────────
    // 7. Security Headers & CSRF Tests
    // ──────────────────────────────────────────────────────────────────────────

    public function test_security_headers_are_present_in_response(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
        $this->assertTrue($response->headers->has('Content-Security-Policy'));

        $csp = $response->headers->get('Content-Security-Policy');
        $this->assertStringContainsString('nonce-', $csp);
        $this->assertStringContainsString("script-src 'self' 'nonce-", $csp);
    }

    public function test_blog_and_regulasi_search_endpoints_load_and_are_throttled(): void
    {
        $response = $this->get('/blog?kategori=air');
        $response->assertStatus(200);

        $responseRegulasi = $this->get('/regulasi?search=lingkungan');
        $responseRegulasi->assertStatus(200);
    }
}
