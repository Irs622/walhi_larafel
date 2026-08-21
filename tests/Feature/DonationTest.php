<?php
 
namespace Tests\Feature;
 
use App\Models\Content;
use App\Models\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
class DonationTest extends TestCase
{
    use RefreshDatabase;
 
    /**
     * Test donation payment request validation.
     */
    public function test_donation_payment_request_requires_parameters(): void
    {
        $response = $this->postJson(route('donasi.pay'), []);
 
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['donor_name', 'donor_email', 'amount']);
    }
 
    /**
     * Test successful mock donation token checkout.
     */
    public function test_donation_checkout_returns_mock_token_when_env_key_empty(): void
    {
        $payload = [
            'donor_name' => 'Wira Pratama',
            'donor_email' => 'donatur@example.org',
            'donor_phone' => '08123456789',
            'amount' => 50000
        ];
 
        $response = $this->postJson(route('donasi.pay'), $payload);
 
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'is_mock' => true
            ]);
            
        $this->assertDatabaseHas('donations', [
            'donor_name' => 'Wira Pratama',
            'donor_email' => 'donatur@example.org',
            'amount' => 50000,
            'status' => 'pending'
        ]);
    }
 
    /**
     * Test simulated mock payment status update.
     */
    public function test_mock_payment_status_update(): void
    {
        $donation = Donation::create([
            'order_id' => 'WALHI-DON-1234567890',
            'donor_name' => 'Budi Santoso',
            'donor_email' => 'budi@example.com',
            'donor_phone' => '08111222333',
            'amount' => 100000,
            'status' => 'pending',
            'snap_token' => 'MOCK-SNAP-TOKEN-123'
        ]);
 
        $response = $this->postJson(route('donasi.mock-payment-status'), [
            'order_id' => 'WALHI-DON-1234567890',
            'status' => 'success'
        ]);
 
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
 
        $this->assertDatabaseHas('donations', [
            'order_id' => 'WALHI-DON-1234567890',
            'status' => 'success'
        ]);
    }
 
    /**
     * Test rendering single content detail page.
     */
    public function test_content_detail_page_renders_successfully(): void
    {
        $content = Content::create([
            'title' => 'Gugatan Izin Lingkungan Cirebon',
            'slug' => 'gugatan-izin-lingkungan-cirebon',
            'category' => 'blog',
            'status' => 'published',
            'body' => 'Isi berita gugatan izin lingkungan di Cirebon.',
            'created_at' => now(),
            'updated_at' => now()
        ]);
 
        $response = $this->get(route('content.show', 'gugatan-izin-lingkungan-cirebon'));
 
        $response->assertStatus(200)
            ->assertSee('Gugatan Izin Lingkungan Cirebon')
            ->assertSee('Isi berita gugatan izin lingkungan di Cirebon.');
    }
}
