<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="{{ $direction ?? (app()->getLocale()==='ar' ? 'rtl' : 'ltr') }}" x-data="{ dark: localStorage.theme === 'dark', menu: false }" :class="{ 'dark': dark }" x-init="$watch('dark', value => localStorage.theme = value ? 'dark' : 'light')">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff" :content="dark ? '#071328' : '#ffffff'">
    <link rel="icon" type="image/png" href="{{ asset('assets/brand/dialo-icon.png') }}">
    <title>@yield('title', app()->getLocale() === 'ar' ? 'Dialo — رقمك للاتصال عبر الإنترنت' : 'Dialo — Your Number. Your Calls.')</title>
    <meta name="description" content="@yield('description', app()->getLocale() === 'ar' ? 'Dialo تطبيق مكالمات صوتية عبر الإنترنت بين مستخدمي Dialo.' : 'Dialo is an Internet voice calling app for Dialo users.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <link rel="alternate" hreflang="ar" href="{{ app()->getLocale() === 'ar' ? url()->current() : url('/'.ltrim(substr(request()->path(), 2), '/') ) }}">
    <link rel="alternate" hreflang="en" href="{{ app()->getLocale() === 'en' ? url()->current() : url('/en'.(request()->path() === '/' ? '' : '/'.request()->path())) }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('title', 'Dialo')">
    <meta property="og:description" content="@yield('description', __('messages.home.hero_text'))">
    <meta property="og:image" content="{{ asset('assets/brand/dialo-icon.png') }}">
    <meta name="twitter:card" content="summary_large_image">
    <script>try{document.documentElement.classList.toggle('dark',localStorage.theme==='dark')}catch(e){}</script>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body>
<a class="skip-link" href="#main">{{ app()->getLocale()==='ar' ? 'تجاوز إلى المحتوى' : 'Skip to content' }}</a>
<header class="reference-header">
    <div class="reference-container header-inner">
        <a href="{{ route(app()->getLocale().'.home') }}" class="header-logo" aria-label="Dialo home">
            <img src="{{ asset('assets/brand/dialo-logo-horizontal.png') }}" alt="Dialo">
        </a>
        <nav class="reference-nav" aria-label="Primary navigation">
            <a @class(['active' => request()->routeIs('ar.home', 'en.home')]) href="{{ route(app()->getLocale().'.home') }}">{{ __('messages.nav.home') }}</a>
            <a @class(['active' => request()->routeIs('ar.features', 'en.features')]) href="{{ route(app()->getLocale().'.features') }}">{{ __('messages.nav.features') }}</a>
            <a @class(['active' => request()->routeIs('ar.how', 'en.how')]) href="{{ route(app()->getLocale().'.how') }}">{{ __('messages.nav.how') }}</a>
            <a @class(['active' => request()->routeIs('ar.security', 'en.security')]) href="{{ route(app()->getLocale().'.security') }}">{{ __('messages.nav.security') }}</a>
            <a @class(['active' => request()->routeIs('ar.faq', 'en.faq')]) href="{{ route(app()->getLocale().'.faq') }}">{{ app()->getLocale()==='ar' ? 'الأسئلة الشائعة' : 'FAQ' }}</a>
            <a @class(['active' => request()->routeIs('ar.help', 'ar.help.show', 'en.help', 'en.help.show')]) href="{{ route(app()->getLocale().'.help') }}">{{ app()->getLocale()==='ar' ? 'مركز المساعدة' : 'Support' }}</a>
            <a @class(['active' => request()->routeIs('ar.contact', 'en.contact')]) href="{{ route(app()->getLocale().'.contact') }}">{{ __('messages.nav.contact') }}</a>
        </nav>
        <div class="header-actions">
            <button class="theme-control" @click="dark=!dark" aria-label="{{ __('messages.theme') }}"><span x-show="!dark">◐</span><span x-show="dark">☀</span></button>
            <a class="download-button" href="{{ route(app()->getLocale().'.home') }}#download">{{ __('messages.download') }} <span aria-hidden="true">↓</span></a>
            <button class="mobile-menu-toggle" @click="menu=!menu" :aria-expanded="menu" aria-controls="mobile-navigation" aria-label="{{ __('messages.menu') }}">☰</button>
        </div>
    </div>
    <nav id="mobile-navigation" class="mobile-reference-nav" x-show="menu" x-transition @click.outside="menu=false">
        <a href="{{ route(app()->getLocale().'.home') }}">{{ __('messages.nav.home') }}</a>
        <a href="{{ route(app()->getLocale().'.features') }}">{{ __('messages.nav.features') }}</a>
        <a href="{{ route(app()->getLocale().'.how') }}">{{ __('messages.nav.how') }}</a>
        <a href="{{ route(app()->getLocale().'.security') }}">{{ __('messages.nav.security') }}</a>
        <a href="{{ route(app()->getLocale().'.faq') }}">{{ __('messages.faq_title') }}</a>
        <a href="{{ route(app()->getLocale().'.help') }}">{{ __('messages.nav.help') }}</a>
        <a href="{{ route(app()->getLocale().'.contact') }}">{{ __('messages.nav.contact') }}</a>
    </nav>
</header>
<main id="main">@yield('content')</main>
<footer class="reference-footer">
    <div class="reference-container footer-columns">
        <section class="footer-brand">
            <img src="{{ asset('assets/brand/dialo-logo-horizontal.png') }}" alt="Dialo">
            <p>{{ app()->getLocale()==='ar' ? 'رقمك للاتصال الصوتي عبر الإنترنت بين مستخدمي Dialo.' : 'Your number for Internet voice calls with other Dialo users.' }}</p>
            <div class="social-row" aria-label="Social links"><span>f</span><span>◎</span><span>𝕏</span><span>▶</span></div>
        </section>
        <section><h2>{{ app()->getLocale()==='ar'?'التطبيق':'Dialo' }}</h2><a href="{{ route(app()->getLocale().'.features') }}">{{ __('messages.nav.features') }}</a><a href="{{ route(app()->getLocale().'.how') }}">{{ __('messages.nav.how') }}</a><a href="{{ route(app()->getLocale().'.security') }}">{{ __('messages.nav.security') }}</a><a href="{{ route(app()->getLocale().'.home') }}#download">{{ __('messages.download') }}</a></section>
        <section><h2>{{ app()->getLocale()==='ar'?'الدعم':'Support' }}</h2><a href="{{ route(app()->getLocale().'.help') }}">{{ __('messages.nav.help') }}</a><a href="{{ route(app()->getLocale().'.faq') }}">{{ __('messages.faq_title') }}</a><a href="{{ route(app()->getLocale().'.contact') }}">{{ __('messages.nav.contact') }}</a></section>
        <section><h2>{{ app()->getLocale()==='ar'?'الشركة':'Legal' }}</h2><a href="{{ route(app()->getLocale().'.privacy') }}">{{ app()->getLocale()==='ar'?'سياسة الخصوصية':'Privacy Policy' }}</a><a href="{{ route(app()->getLocale().'.terms') }}">{{ app()->getLocale()==='ar'?'الشروط والأحكام':'Terms of Use' }}</a><a href="{{ route(app()->getLocale().'.cookies') }}">{{ app()->getLocale()==='ar'?'ملفات الارتباط':'Cookie Information' }}</a></section>
    </div>
    <div class="reference-container footer-bottom">
        <span>© {{ date('Y') }} Dialo. {{ app()->getLocale()==='ar'?'جميع الحقوق محفوظة.':'All rights reserved.' }}</span>
        <div class="footer-controls">
            @php
                $languageTarget = app()->getLocale() === 'ar' ? 'en' : 'ar';
                $localizedPath = app()->getLocale() === 'ar'
                    ? '/en'.(request()->path() === '/' ? '' : '/'.request()->path())
                    : '/'.ltrim(substr(request()->path(), 2), '/');
            @endphp
            <a href="{{ route('language.switch', ['locale' => $languageTarget, 'redirect' => $localizedPath]) }}">◎ {{ __('messages.language') }}</a>
            <button class="footer-theme-toggle" @click="dark=!dark" :aria-pressed="dark" aria-label="{{ __('messages.theme') }}">
                <span x-show="!dark">☾ {{ __('messages.dark_mode') }}</span>
                <span x-show="dark">☀ {{ __('messages.light_mode') }}</span>
            </button>
        </div>
    </div>
</footer>
</body>
</html>
