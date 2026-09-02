<?php
 
namespace Tests\Feature;
 
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
 
class SEOAndResponsiveTest extends TestCase
{
    use RefreshDatabase;
 
    protected function setUp(): void
    {
        parent::setUp();
        // Seed database for sitemap contents
        $this->seed(\Database\Seeders\ContentSeeder::class);
    }
 
    /**
     * Test sitemap XML renders successfully.
     */
    public function test_sitemap_xml_loads(): void
    {
        $response = $this->get(route('sitemap'));
 
        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/xml; charset=UTF-8')
            ->assertSee('<urlset', false)
            ->assertSee('<loc>http://localhost</loc>', false)
            ->assertSee('krisis-air-citarum');
    }
 
    /**
     * Test robots.txt loads and contains disallow rules.
     */
    public function test_robots_txt_loads(): void
    {
        $response = $this->get('/robots.txt');
 
        $response->assertStatus(200)
            ->assertSee('User-agent: *')
            ->assertSee('Disallow: /admin')
            ->assertSee('Disallow: /login')
            ->assertSee('Disallow: /register')
            ->assertSee('Disallow: /profile')
            ->assertSee('Sitemap:');
    }
 
    /**
     * Test SEO Meta tags are rendered on welcome page.
     */
    public function test_seo_meta_tags_on_welcome_page(): void
    {
        $response = $this->get('/');
 
        $response->assertStatus(200)
            ->assertSee('<meta name="description"', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('property="og:description"', false)
            ->assertSee('property="twitter:title"', false);
    }
 
    /**
     * Test dynamic article SEO tags, Open Graph, and JSON-LD schema on content detail page.
     */
    public function test_article_detail_has_dynamic_seo_and_open_graph(): void
    {
        $content = \App\Models\Content::published()->first();
        $this->assertNotNull($content);
 
        $response = $this->get(route('content.show', $content->slug));
 
        $response->assertStatus(200)
            ->assertSee('<title>' . e($content->title) . ' - WALHI Jawa Barat</title>', false)
            ->assertSee('property="og:title"', false)
            ->assertSee('property="og:type" content="article"', false)
            ->assertSee('name="twitter:card" content="summary_large_image"', false)
            ->assertSee('application/ld+json', false)
            ->assertSee('NewsArticle', false);
    }
 
    /**
     * Test admin routes have noindex meta tag and X-Robots-Tag response header.
     */
    public function test_admin_routes_have_noindex_and_x_robots_tag(): void
    {
        $admin = \App\Models\User::factory()->create([
            'role' => 'admin',
        ]);
 
        $response = $this->actingAs($admin)->get('/admin');
 
        $response->assertStatus(200)
            ->assertHeader('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet')
            ->assertSee('<meta name="robots" content="noindex, nofollow, noarchive, nosnippet">', false)
            ->assertSee('<meta name="googlebot" content="noindex, nofollow, noarchive, nosnippet">', false);
    }

    /**
     * Test newly added publication routes render successfully.
     */
    public function test_publication_routes_render(): void
    {
        $responseKertas = $this->get(route('kertas-posisi'));
        $responseKertas->assertStatus(200)
            ->assertSee('KERTAS POSISI');

        $responseCatatan = $this->get(route('catatan-kritis'));
        $responseCatatan->assertStatus(200)
            ->assertSee('CATATAN KRITIS');
    }

    /**
     * Test donation page contains updated presets and WhatsApp direct narrative.
     */
    public function test_donation_page_contains_wa_narrative_and_presets(): void
    {
        $response = $this->get(route('donasi'));
        $response->assertStatus(200)
            ->assertSee('Ingin berdonasi untuk lingkungan hidup?')
            ->assertSee('6282119821159')
            ->assertSee('Rp 10.000')
            ->assertSee('Rp 150.000');
    }

    /**
     * Test tentang kami page contains updated vision and leadership.
     */
    public function test_tentang_kami_page_content(): void
    {
        $response = $this->get(route('about'));
        $response->assertStatus(200)
            ->assertSee('Wahyudin')
            ->assertSee('Dedy Kurniawan')
            ->assertSee('Jl. Simponi No.29')
            ->assertSee('walhijabar@gmail.com')
            ->assertDontSee('walhijabar@walhijabar.id');
    }
}
