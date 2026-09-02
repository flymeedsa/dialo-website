@extends('layouts.public')
@section('title', $page->localized('seo_title') ?: $page->localized('title').' — Dialo')
@section('description', $page->localized('seo_description') ?: $page->localized('excerpt'))
@section('content')
<section class="page-hero inner-page-hero">
    <div class="container narrow"><span class="eyebrow">DIALO</span><h1>{{ $page->localized('title') }}</h1><p>{{ $page->localized('excerpt') }}</p></div>
</section>

@if($page->key === 'features')
<section class="section inner-content-section"><div class="container">
    <div class="approved-feature-grid inner-feature-grid">
        @foreach(__('messages.home.features') as $feature)
            <article class="approved-feature-card"><span class="approved-icon"><x-site-icon :name="$feature['icon']" /></span><h2>{{ $feature['title'] }}</h2><p>{{ $feature['text'] }}</p></article>
        @endforeach
    </div>
    <article class="product-truth-card"><strong dir="ltr">0800 905 066</strong><div><h2>{{ __('messages.number_title') }}</h2><p>{{ __('messages.number_text') }}</p></div></article>
</div></section>
@elseif($page->key === 'how-dialo-works')
<section class="section inner-content-section"><div class="container">
    <div class="approved-steps inner-steps">
        @foreach(__('messages.home.steps') as $step)
            <article class="approved-step-card"><span class="step-number">{{ $loop->iteration }}</span><span class="step-icon"><x-site-icon :name="$step['icon']" /></span><div><h2>{{ $step['title'] }}</h2><p>{{ $step['text'] }}</p></div></article>
        @endforeach
    </div>
    <article class="product-note"><x-site-icon name="call" /><p>{{ $page->localized('body') }}</p></article>
</div></section>
@elseif($page->key === 'security')
<section class="section inner-content-section"><div class="container security-panel">
    <div class="security-illustration" aria-hidden="true"><div class="security-ring ring-a"></div><div class="security-ring ring-b"></div><span class="security-shield"><x-site-icon name="lock" /></span></div>
    <div class="security-content"><h2>{{ __('messages.home.security_title') }}</h2><p>{{ $page->localized('body') }}</p><div class="security-items">@foreach(__('messages.home.security_items') as $item)<article><span><x-site-icon name="shield" /></span><h3>{{ $item['title'] }}</h3><p>{{ $item['text'] }}</p></article>@endforeach</div></div>
</div></section>
@else
<section class="section inner-content-section"><article class="container narrow prose legal-prose">{!! nl2br(e($page->localized('body'))) !!}</article></section>
@endif

<x-inner-cta />
@endsection
