@extends('layouts.public')
@section('title', app()->getLocale()==='ar' ? 'Dialo — رقمك للاتصال عبر الإنترنت' : 'Dialo — Your Number. Your Calls. Anywhere.')
@section('description', __('messages.home.hero_text'))
@section('content')
<section class="approved-hero">
    <div class="hero-wave wave-one"></div><div class="hero-wave wave-two"></div>
    <div class="reference-container approved-hero-grid">
        <div class="approved-hero-copy">
            @if(app()->getLocale()==='ar')
                <h1><span>Dialo</span><br>رقمك للاتصال<br>عبر الإنترنت</h1>
            @else
                <h1>Your Number.<br><span>Your Calls.</span><br>Anywhere.</h1>
            @endif
            <p>{{ __('messages.home.hero_text') }}</p>
            <x-store-badges />
            <div class="hero-trust">@foreach(__('messages.home.trust') as $item)<span><i>✓</i>{{ $item }}</span>@endforeach</div>
        </div>
        <div class="approved-phones" aria-label="Dialo voice calling preview">
            <x-phone-mockup screen="dialpad" tilt="left" />
            <x-phone-mockup screen="incoming" tilt="right" />
        </div>
    </div>
</section>

<section id="features" class="approved-section why-section">
    <div class="reference-container">
        <h2 class="approved-heading">{{ __('messages.home.why_title') }}</h2>
        <div class="approved-feature-grid">
            @foreach(__('messages.home.features') as $feature)
                <article class="approved-feature-card">
                    <span class="approved-icon"><x-site-icon :name="$feature['icon']" /></span>
                    <h3>{{ $feature['title'] }}</h3>
                    <p>{{ $feature['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="how" class="approved-section how-section">
    <div class="reference-container">
        <h2 class="approved-heading">{{ __('messages.home.how_title') }}</h2>
        <div class="approved-steps">
            @foreach(__('messages.home.steps') as $step)
                <article class="approved-step-card">
                    <span class="step-number">{{ $loop->iteration }}</span>
                    <span class="step-icon"><x-site-icon :name="$step['icon']" /></span>
                    <div><h3>{{ $step['title'] }}</h3><p>{{ $step['text'] }}</p></div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="approved-section experience-section">
    <div class="reference-container">
        <h2 class="approved-heading">{{ __('messages.home.experience_title') }}</h2>
        <div class="experience-grid">
            @foreach(['contacts','incoming','incall'] as $screen)
                <article class="experience-card">
                    <div class="experience-phone-wrap"><x-phone-mockup :screen="$screen" /></div>
                    <h3>{{ __('messages.home.experience.'.$loop->index.'.title') }}</h3>
                    <p>{{ __('messages.home.experience.'.$loop->index.'.text') }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section id="security" class="approved-section security-section">
    <div class="reference-container security-panel">
        <div class="security-illustration" aria-hidden="true">
            <div class="security-ring ring-a"></div><div class="security-ring ring-b"></div>
            <span class="security-shield"><x-site-icon name="lock" /></span>
        </div>
        <div class="security-content">
            <h2>{{ __('messages.home.security_title') }}</h2>
            <p>{{ __('messages.home.security_text') }}</p>
            <div class="security-items">
                @foreach(__('messages.home.security_items') as $item)
                    <article><span><x-site-icon name="shield" /></span><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></article>
                @endforeach
            </div>
        </div>
    </div>
</section>

<section class="approved-section faq-preview-section">
    <div class="reference-container">
        <h2 class="approved-heading">{{ __('messages.home.faq_title') }}</h2>
        <div class="approved-faq-grid">
            @forelse($faqs->take(6) as $faq)
                <details class="approved-faq-item"><summary>{{ $faq->localized('question') }}<span>⌄</span></summary><p>{{ $faq->localized('answer') }}</p></details>
            @empty
                <p class="empty-message">{{ app()->getLocale()==='ar'?'سيتم نشر الأسئلة قريبًا.':'Questions will be published soon.' }}</p>
            @endforelse
        </div>
        <a class="view-all-faq" href="{{ route(app()->getLocale().'.faq') }}">{{ app()->getLocale()==='ar'?'عرض جميع الأسئلة الشائعة':'View all FAQs' }} <span>→</span></a>
    </div>
</section>

<section id="download" class="download-section">
    <div class="reference-container approved-download-panel">
        <div class="download-phone" aria-hidden="true"><div><img src="{{ asset('assets/brand/dialo-icon.png') }}" alt=""></div></div>
        <div class="download-copy"><span class="coming-pill">{{ __('messages.download_soon') }}</span><h2>{{ __('messages.home.cta_title') }}</h2><p>{{ __('messages.home.cta_text') }}</p><x-store-badges compact /></div>
    </div>
</section>

@endsection
