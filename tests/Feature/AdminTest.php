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

    public function test_editor_image_upload_under_2mb_returns_json_url(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $file = \Illuminate\Http\UploadedFile::fake()->image('editor_photo.jpg', 600, 400)->size(1200); // 1.2 MB

        $response = $this->postJson('/admin/upload-image', [
            'image' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'url',
        ]);
        $this->assertTrue(str_contains($response->json('url'), '/storage/uploads/'));
    }

    public function test_editor_image_upload_over_2mb_is_rejected(): void
    {
        \Illuminate\Support\Facades\Storage::fake('public');

        $largeFile = \Illuminate\Http\UploadedFile::fake()->image('huge_photo.jpg', 3000, 3000)->size(3500); // 3.5 MB

        $response = $this->postJson('/admin/upload-image', [
            'image' => $largeFile,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('image');
    }
}
