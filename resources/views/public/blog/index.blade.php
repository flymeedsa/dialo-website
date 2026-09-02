@extends('layouts.public')
@section('title', __('messages.blog_title').' — Dialo')
@section('content')
<section class="page-hero inner-page-hero"><div class="container narrow"><span class="eyebrow">DIALO JOURNAL</span><h1>{{ __('messages.blog_title') }}</h1><p>{{ app()->getLocale()==='ar'?'أخبار المنتج والإتاحة والتحديثات الرسمية من فريق Dialo.':'Product news, availability, and official updates from the Dialo team.' }}</p></div></section>
<section class="section inner-content-section"><div class="container post-grid">@forelse($posts as $post)<a class="post-card" href="{{ route(app()->getLocale().'.blog.show',$post->slug) }}"><span>{{ $post->category?->localized('name') }} · {{ $post->published_at?->format('Y.m.d') }}</span><h2>{{ $post->localized('title') }}</h2><p>{{ $post->localized('excerpt') }}</p><b>{{ app()->getLocale()==='ar'?'اقرأ المقال ←':'Read article →' }}</b></a>@empty<div class="empty-state">{{ app()->getLocale()==='ar'?'لا توجد مقالات منشورة حاليًا.':'No published posts yet.' }}</div>@endforelse</div><div class="container pagination">{{ $posts->links() }}</div></section>
<x-inner-cta />
@endsection
