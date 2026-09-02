<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Faq;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index(string $type)
    {
        [$model, $title] = $this->definition($type);
        $items = $model::query()->latest()->paginate(20);

        return view('admin.content.index', compact('items', 'type', 'title'));
    }

    public function create(string $type)
    {
        [, $title] = $this->definition($type);

        return view('admin.content.form', ['item' => null, 'type' => $type, 'title' => $title, 'options' => $this->options($type)]);
    }

    public function store(Request $request, string $type)
    {
        [$model] = $this->definition($type);
        $data = $this->validated($request, $type);
        if ($type === 'posts') {
            $data['author_id'] = $request->user()->id;
        }
        $model::create($data);

        return redirect()->route('admin.content.index', $type)->with('success', 'تم الحفظ بنجاح.');
    }

    public function edit(string $type, int $id)
    {
        [$model, $title] = $this->definition($type);

        return view('admin.content.form', ['item' => $model::findOrFail($id), 'type' => $type, 'title' => $title, 'options' => $this->options($type)]);
    }

    public function update(Request $request, string $type, int $id)
    {
        [$model] = $this->definition($type);
        $item = $model::findOrFail($id);
        $item->update($this->validated($request, $type, $item));

        return redirect()->route('admin.content.index', $type)->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(string $type, int $id)
    {
        [$model] = $this->definition($type);
        $model::findOrFail($id)->delete();

        return back()->with('success', 'تم الحذف.');
    }

    public function settings()
    {
        return view('admin.settings', ['settings' => SiteSetting::query()->orderBy('key')->get()->keyBy('key')]);
    }

    public function updateSettings(Request $request)
    {
        $data = $request->validate([
            'site_name_ar' => ['required', 'string', 'max:100'], 'site_name_en' => ['required', 'string', 'max:100'],
            'contact_email' => ['nullable', 'email'], 'app_store_url' => ['nullable', 'url'], 'google_play_url' => ['nullable', 'url'],
            'downloads_enabled' => ['nullable', 'boolean'], 'social_x_url' => ['nullable', 'url'],
        ]);
        $data['downloads_enabled'] = $request->boolean('downloads_enabled') ? '1' : '0';
        foreach ($data as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'تم حفظ الإعدادات.');
    }

    public function inquiries()
    {
        return view('admin.inquiries', ['items' => ContactSubmission::latest()->paginate(30)]);
    }

    public function closeInquiry(int $id)
    {
        ContactSubmission::findOrFail($id)->update(['status' => 'closed']);

        return back()->with('success', 'تم إغلاق الطلب.');
    }

    private function definition(string $type): array
    {
        return match ($type) {
            'pages' => [Page::class, 'الصفحات'], 'posts' => [BlogPost::class, 'المدونة'],
            'categories' => [BlogCategory::class, 'تصنيفات المدونة'], 'help-categories' => [HelpCategory::class, 'تصنيفات المساعدة'],
            'articles' => [HelpArticle::class, 'مقالات المساعدة'], 'faqs' => [Faq::class, 'الأسئلة الشائعة'],
            default => abort(404),
        };
    }

    private function options(string $type): array
    {
        return match ($type) {
            'posts' => BlogCategory::pluck('name_ar', 'id')->all(),
            'articles' => HelpCategory::pluck('name_ar', 'id')->all(),
            default => [],
        };
    }

    private function validated(Request $request, string $type, ?Model $item = null): array
    {
        $id = $item?->getKey();
        $titles = ['title_ar' => ['required', 'string', 'max:255'], 'title_en' => ['required', 'string', 'max:255']];
        $rules = match ($type) {
            'pages' => $titles + ['key' => ['required', 'alpha_dash', 'max:80', 'unique:pages,key,'.$id], 'slug' => ['required', 'alpha_dash', 'max:160', 'unique:pages,slug,'.$id], 'excerpt_ar' => ['nullable', 'string'], 'excerpt_en' => ['nullable', 'string'], 'body_ar' => ['nullable', 'string'], 'body_en' => ['nullable', 'string'], 'is_published' => ['nullable', 'boolean']],
            'posts' => $titles + ['blog_category_id' => ['nullable', 'exists:blog_categories,id'], 'slug' => ['required', 'alpha_dash', 'max:160', 'unique:blog_posts,slug,'.$id], 'excerpt_ar' => ['required', 'string'], 'excerpt_en' => ['required', 'string'], 'body_ar' => ['required', 'string'], 'body_en' => ['required', 'string'], 'status' => ['required', 'in:draft,published'], 'published_at' => ['nullable', 'date']],
            'categories' => ['name_ar' => ['required', 'string', 'max:160'], 'name_en' => ['required', 'string', 'max:160'], 'slug' => ['required', 'alpha_dash', 'max:160', 'unique:blog_categories,slug,'.$id]],
            'help-categories' => ['name_ar' => ['required', 'string', 'max:160'], 'name_en' => ['required', 'string', 'max:160'], 'slug' => ['required', 'alpha_dash', 'max:160', 'unique:help_categories,slug,'.$id], 'sort_order' => ['required', 'integer', 'min:0'], 'is_visible' => ['nullable', 'boolean']],
            'articles' => $titles + ['help_category_id' => ['required', 'exists:help_categories,id'], 'slug' => ['required', 'alpha_dash', 'max:160', 'unique:help_articles,slug,'.$id], 'excerpt_ar' => ['nullable', 'string'], 'excerpt_en' => ['nullable', 'string'], 'body_ar' => ['required', 'string'], 'body_en' => ['required', 'string'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_published' => ['nullable', 'boolean']],
            'faqs' => ['question_ar' => ['required', 'string', 'max:500'], 'question_en' => ['required', 'string', 'max:500'], 'answer_ar' => ['required', 'string'], 'answer_en' => ['required', 'string'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_visible' => ['nullable', 'boolean']],
            default => abort(404),
        };
        $data = $request->validate($rules);
        foreach (['is_published', 'is_visible'] as $boolean) {
            if (array_key_exists($boolean, $rules)) {
                $data[$boolean] = $request->boolean($boolean);
            }
        }
        if ($type === 'posts' && $data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }
}
