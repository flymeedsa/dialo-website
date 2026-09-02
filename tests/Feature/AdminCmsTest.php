<?php

namespace Tests\Feature;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCmsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_cms(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
    }

    public function test_non_admin_is_forbidden(): void
    {
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
    }

    public function test_admin_can_create_and_update_faq(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->post('/admin/faqs', ['question_ar' => 'سؤال تجريبي', 'question_en' => 'Test question', 'answer_ar' => 'إجابة', 'answer_en' => 'Answer', 'sort_order' => 2, 'is_visible' => 1])->assertSessionHasNoErrors()->assertRedirect('/admin/faqs');
        $faq = Faq::where('question_en', 'Test question')->firstOrFail();
        $this->actingAs($admin)->put('/admin/faqs/'.$faq->id, ['question_ar' => 'سؤال محدث', 'question_en' => 'Updated question', 'answer_ar' => 'إجابة', 'answer_en' => 'Answer', 'sort_order' => 3, 'is_visible' => 1])->assertSessionHasNoErrors()->assertRedirect('/admin/faqs');
        $this->assertDatabaseHas('faqs', ['id' => $faq->id, 'question_en' => 'Updated question']);
    }

    public function test_admin_can_publish_blog_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->post('/admin/posts', ['slug' => 'release-note', 'title_ar' => 'تحديث', 'title_en' => 'Update', 'excerpt_ar' => 'ملخص', 'excerpt_en' => 'Summary', 'body_ar' => 'المحتوى', 'body_en' => 'Content', 'status' => 'published', 'published_at' => now()->format('Y-m-d H:i:s')])->assertSessionHasNoErrors()->assertRedirect('/admin/posts');
        $this->get('/en/blog/release-note')->assertOk()->assertSee('Update');
    }
}
