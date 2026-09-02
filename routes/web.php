<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PublicSiteController;
use App\Models\BlogPost;
use App\Models\HelpArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$publicRoutes = function () {
    Route::get('/', [PublicSiteController::class, 'home'])->name('home');
    Route::get('/features', fn () => app(PublicSiteController::class)->page('features'))->name('features');
    Route::get('/how-dialo-works', fn () => app(PublicSiteController::class)->page('how-dialo-works'))->name('how');
    Route::get('/security', fn () => app(PublicSiteController::class)->page('security'))->name('security');
    Route::get('/privacy', fn () => app(PublicSiteController::class)->page('privacy'))->name('privacy');
    Route::get('/terms', fn () => app(PublicSiteController::class)->page('terms'))->name('terms');
    Route::get('/cookies', fn () => app(PublicSiteController::class)->page('cookies'))->name('cookies');
    Route::get('/blog', [PublicSiteController::class, 'blog'])->name('blog');
    Route::get('/blog/{slug}', [PublicSiteController::class, 'post'])->name('blog.show');
    Route::get('/help', [PublicSiteController::class, 'help'])->name('help');
    Route::get('/help/{slug}', [PublicSiteController::class, 'article'])->name('help.show');
    Route::get('/faq', [PublicSiteController::class, 'faq'])->name('faq');
    Route::get('/contact', [PublicSiteController::class, 'contact'])->name('contact');
    Route::post('/contact', [PublicSiteController::class, 'storeContact'])->middleware('throttle:5,60')->name('contact.store');
};

Route::get('/language/{locale}', function (Request $request, string $locale) {
    abort_unless(in_array($locale, ['ar', 'en'], true), 404);

    $fallback = $locale === 'en' ? '/en' : '/';
    $redirect = (string) $request->query('redirect', $fallback);

    if (! str_starts_with($redirect, '/') || str_starts_with($redirect, '//')) {
        $redirect = $fallback;
    }

    return redirect()->to($redirect)->withCookie(cookie('dialo_locale', $locale, 60 * 24 * 365));
})->whereIn('locale', ['ar', 'en'])->name('language.switch');

Route::middleware('locale:ar')->name('ar.')->group($publicRoutes);
Route::prefix('en')->middleware('locale:en')->name('en.')->group($publicRoutes);

Route::get('/sitemap.xml', function () {
    $urls = collect(['/', '/features', '/how-dialo-works', '/security', '/help', '/faq', '/blog', '/contact', '/privacy', '/terms', '/cookies']);
    $dynamic = BlogPost::published()->pluck('slug')->map(fn ($s) => '/blog/'.$s)
        ->concat(HelpArticle::where('is_published', true)->pluck('slug')->map(fn ($s) => '/help/'.$s));

    return response()->view('public.sitemap', ['urls' => $urls->concat($dynamic)], 200, ['Content-Type' => 'application/xml']);
});
Route::get('/robots.txt', fn () => response("User-agent: *\nAllow: /\nDisallow: /admin\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']));

Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'store'])->middleware('throttle:5,1')->name('admin.login.store');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
    Route::get('/settings', [ContentController::class, 'settings'])->name('settings');
    Route::put('/settings', [ContentController::class, 'updateSettings'])->name('settings.update');
    Route::get('/inquiries', [ContentController::class, 'inquiries'])->name('inquiries');
    Route::patch('/inquiries/{id}/close', [ContentController::class, 'closeInquiry'])->name('inquiries.close');
    Route::get('/{type}', [ContentController::class, 'index'])->name('content.index');
    Route::get('/{type}/create', [ContentController::class, 'create'])->name('content.create');
    Route::post('/{type}', [ContentController::class, 'store'])->name('content.store');
    Route::get('/{type}/{id}/edit', [ContentController::class, 'edit'])->name('content.edit');
    Route::put('/{type}/{id}', [ContentController::class, 'update'])->name('content.update');
    Route::delete('/{type}/{id}', [ContentController::class, 'destroy'])->name('content.destroy');
});
