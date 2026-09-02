<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\ContactSubmission;
use App\Models\Faq;
use App\Models\HelpArticle;
use App\Models\HelpCategory;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class PublicSiteController extends Controller
{
    public function home(): View
    {
        return view('public.home', [
            'faqs' => Faq::query()->where('is_visible', true)->orderBy('sort_order')->limit(6)->get(),
            'posts' => BlogPost::published()->latest('published_at')->limit(3)->get(),
            'downloadEnabled' => SiteSetting::valueFor('downloads_enabled', '0') === '1',
        ]);
    }

    public function page(string $slug): View
    {
        $page = Page::query()->where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('public.page', compact('page'));
    }

    public function blog(): View
    {
        return view('public.blog.index', ['posts' => BlogPost::published()->with('category')->latest('published_at')->paginate(9)]);
    }

    public function post(string $slug): View
    {
        $post = BlogPost::published()->with(['category', 'author'])->where('slug', $slug)->firstOrFail();

        return view('public.blog.show', compact('post'));
    }

    public function help(Request $request): View
    {
        $term = trim((string) $request->query('q'));
        $categories = HelpCategory::query()->where('is_visible', true)->with(['articles' => fn ($q) => $q->where('is_published', true)->when($term, fn ($q) => $q->where(fn ($q) => $q->where('title_ar', 'like', "%{$term}%")->orWhere('title_en', 'like', "%{$term}%")))->orderBy('sort_order')])->orderBy('sort_order')->get();

        return view('public.help.index', compact('categories', 'term'));
    }

    public function article(string $slug): View
    {
        $article = HelpArticle::query()->where('slug', $slug)->where('is_published', true)->with('category')->firstOrFail();

        return view('public.help.show', compact('article'));
    }

    public function faq(): View
    {
        return view('public.faq', ['faqs' => Faq::query()->where('is_visible', true)->orderBy('sort_order')->get()]);
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function storeContact(Request $request)
    {
        $key = 'contact:'.hash('sha256', (string) $request->ip());
        abort_if(RateLimiter::tooManyAttempts($key, 5), 429);
        RateLimiter::hit($key, 3600);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'], 'email' => ['required', 'email', 'max:180'],
            'subject' => ['required', 'string', 'max:180'], 'message' => ['required', 'string', 'max:5000'],
            'website' => ['nullable', 'max:0'],
        ]);
        unset($data['website']);
        $data['locale'] = app()->getLocale();
        $data['ip_hash'] = hash_hmac('sha256', (string) $request->ip(), config('app.key'));
        ContactSubmission::create($data);

        return back()->with('success', __('messages.contact_success'));
    }
}
