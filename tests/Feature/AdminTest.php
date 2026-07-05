<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
 
class AdminTest extends TestCase
{
    use RefreshDatabase;
 
    protected function setUp(): void
    {
        parent::setUp();
        // Seed database for testing queries
        $this->seed(\Database\Seeders\ContentSeeder::class);
        
        // Authenticate user
        $user = User::factory()->create();
        $this->actingAs($user);
    }
 
    public function test_admin_dashboard_loads(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(200);
    }
 
    public function test_admin_blog_loads(): void
    {
        $response = $this->get('/admin/blog');
        $response->assertStatus(200);
    }
 
    public function test_admin_donasi_loads(): void
    {
        $response = $this->get('/admin/donasi');
        $response->assertStatus(200);
    }
 
    public function test_admin_pekan_rakyat_loads(): void
    {
        $response = $this->get('/admin/pekan-rakyat');
        $response->assertStatus(200);
    }
 
    public function test_admin_sejarah_loads(): void
    {
        $response = $this->get('/admin/tentang/sejarah');
        $response->assertStatus(200);
    }
}
