@extends('layouts.public')
@section('title', __('messages.faq_title').' — Dialo')
@section('content')
<section class="page-hero inner-page-hero"><div class="container narrow"><span class="eyebrow">FAQ</span><h1>{{ __('messages.faq_title') }}</h1><p>{{ app()->getLocale()==='ar'?'إجابات واضحة عن أرقام Dialo والمكالمات والخصوصية.':'Clear answers about Dialo numbers, calling, and privacy.' }}</p></div></section>
<section class="section inner-content-section"><div class="container approved-faq-grid faq-page-grid">@foreach($faqs as $faq)<details class="approved-faq-item"><summary>{{ $faq->localized('question') }}<span>⌄</span></summary><p>{{ $faq->localized('answer') }}</p></details>@endforeach</div></section>
<x-inner-cta />
@endsection
