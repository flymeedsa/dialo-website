<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetPublicLocale
{
    public function handle(Request $request, Closure $next, string $locale): Response
    {
        abort_unless(in_array($locale, ['ar', 'en'], true), 404);

        if ($locale === 'ar' && $request->isMethod('GET')) {
            $preferredLocale = $request->cookie('dialo_locale');

            if (! $preferredLocale) {
                $preferredLocale = $request->hasHeader('Accept-Language')
                    ? $request->getPreferredLanguage(['ar', 'en'])
                    : 'ar';
            }

            if ($preferredLocale === 'en') {
                $path = $request->path() === '/' ? '' : '/'.ltrim($request->path(), '/');
                $target = '/en'.$path;

                if ($request->getQueryString()) {
                    $target .= '?'.$request->getQueryString();
                }

                return redirect()->to($target);
            }
        }

        app()->setLocale($locale);
        view()->share('locale', $locale);
        view()->share('direction', $locale === 'ar' ? 'rtl' : 'ltr');

        return $next($request);
    }
}
