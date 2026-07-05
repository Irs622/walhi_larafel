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
     * Test robots.txt loads.
     */
    public function test_robots_txt_loads(): void
    {
        $response = $this->get('/robots.txt');
 
        $response->assertStatus(200)
            ->assertSee('User-agent: *')
            ->assertSee('Disallow: /admin')
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
}
