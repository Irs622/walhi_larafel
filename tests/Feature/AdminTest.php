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
        $user = User::factory()->admin()->create();
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

    public function test_admin_comments_loads(): void
    {
        $response = $this->get('/admin/comments');
        $response->assertStatus(200);
    }

    public function test_admin_subscribers_loads(): void
    {
        $response = $this->get('/admin/subscribers');
        $response->assertStatus(200);
    }

    public function test_content_image_upload_under_2mb_succeeds(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $file = \Illuminate\Http\UploadedFile::fake()->image('cover.jpg', 800, 600)->size(1500); // 1.5 MB

        $response = $this->post('/admin/blog', [
            'title'        => 'Artikel Uji Gambar',
            'slug'         => 'artikel-uji-gambar',
            'status'       => 'published',
            'body'         => '<p>Isi artikel dengan gambar.</p>',
            'image'        => $file,
            'publish_date' => '2026-08-22',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('contents', [
            'slug' => 'artikel-uji-gambar',
        ]);

        $content = \App\Models\Content::where('slug', 'artikel-uji-gambar')->first();
        $this->assertNotNull($content->image_url);
        $this->assertTrue(str_contains($content->image_url, '/storage/uploads/'));

        // Verify post detail page renders the image properly
        $publicRes = $this->get('/konten/artikel-uji-gambar');
        $publicRes->assertStatus(200);
        $publicRes->assertSee($content->image_url);
    }

    public function test_content_image_upload_over_2mb_is_rejected(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $largeFile = \Illuminate\Http\UploadedFile::fake()->image('huge.jpg', 2000, 2000)->size(3000); // 3 MB (exceeds 2MB)

        $response = $this->post('/admin/blog', [
            'title'        => 'Artikel Gambar Terlalu Besar',
            'slug'         => 'artikel-gambar-besar',
            'status'       => 'published',
            'body'         => '<p>Test</p>',
            'image'        => $largeFile,
            'publish_date' => '2026-08-22',
        ]);

        $response->assertSessionHasErrors('image');
    }
}
