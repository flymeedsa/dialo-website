<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicWebsiteTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_arabic_home_is_rtl_and_accurate(): void
    {
        $this->withCookie('dialo_locale', 'ar')->get('/')->assertOk()->assertSee('dir="rtl"', false)->assertSee('0800 905 066')->assertSee('رقمك للاتصال');
    }

    public function test_english_home_is_ltr(): void
    {
        $this->get('/en')->assertOk()->assertSee('dir="ltr"', false)->assertSee('Your Number')->assertSee('0800 905 066');
    }

    public function test_device_language_selects_english_on_first_visit(): void
    {
        $this->withHeader('Accept-Language', 'en-US,en;q=0.9')->get('/')
            ->assertRedirect('/en');
    }

    public function test_manual_language_choice_is_remembered(): void
    {
        $this->get('/language/en?redirect=/en')
            ->assertRedirect('/en')
            ->assertCookie('dialo_locale', 'en');

        $this->withCookie('dialo_locale', 'ar')
            ->withHeader('Accept-Language', 'en-US,en;q=0.9')
            ->get('/')
            ->assertOk()
            ->assertSee('dir="rtl"', false);
    }

    public function test_light_mode_is_default_and_theme_toggle_is_available(): void
    {
        $this->withCookie('dialo_locale', 'ar')->get('/')
            ->assertOk()
            ->assertSee("localStorage.theme === 'dark'", false)
            ->assertSee('الوضع الليلي');

        $this->get('/en')
            ->assertOk()
            ->assertSee('Dark mode');
    }

    public function test_core_public_content_flows_render(): void
    {
        $this->withCookie('dialo_locale', 'ar');

        foreach (['/features', '/en/security', '/blog', '/blog/welcome-to-dialo', '/help', '/help/what-is-dialo', '/faq', '/contact', '/privacy', '/terms', '/cookies', '/sitemap.xml', '/robots.txt'] as $uri) {
            $this->get($uri)->assertOk();
        }
    }

    public function test_contact_submission_is_validated_and_stored(): void
    {
        $this->post('/contact', ['name' => 'Test User', 'email' => 'person@example.com', 'subject' => 'Support', 'message' => 'A valid support request.', 'website' => ''])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertDatabaseHas('contact_submissions', ['email' => 'person@example.com', 'locale' => 'ar']);
    }

    public function test_unpublished_content_is_not_public(): void
    {
        BlogPost::where('slug', 'welcome-to-dialo')->update(['status' => 'draft']);
        $this->withCookie('dialo_locale', 'ar')->get('/blog/welcome-to-dialo')->assertNotFound();
    }
}
